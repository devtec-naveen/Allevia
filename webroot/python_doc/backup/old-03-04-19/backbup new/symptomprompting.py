# -*- coding: utf-8 -*-
"""
Created on Sat Jul 01 13:55:31 2017

@author: John
"""
#lean file for symptom prompting on website
import numpy as np
#import pickle
import sys, json
try:
    php_param = json.loads(sys.argv[1])
    spec = sys.argv[2]
#php_param = eval(sys.argv[1])
#php_param = base64.b64decode(sys.argv[1])
except:
    print(json.dumps("ERROR"))
    sys.exit(1)
#synonyms is for user input -> technical, technical_to_layman is for technical -> user reading
def symptom_prompting(current_symptoms_input, specialization):
    '''
    The primary symptom prompting machine learning routine for Allevia.
    Inputs:
        current_symptoms_input - an array of the current symptoms where is a negative 
            is expressed as 'no whateversymptom'. e.g. an input array might be
            ["cough", "no fever"]. Symptoms that the patient doesn't mention and doesn't
            deny are not considered absent.
        specialization - "GEN" for general, "OBGYN" for ob/gyn, "ORTHO" for orthopedics.
                            Used to prompt different files for the symptom prompting stage.
    Outputs:
        {'layman': array of potential symptoms in layman terms, 'technical': array of
        symptoms in technical terms} - A converter is provided too but since internal
        calculations use technical terms, there would be no reason not to return it to.
        The doctor receives the technical symptoms, the patient sees the layman symptoms.
    
    '''
    specialization_to_filename = {"GEN": "/opt/lampp/htdocs/allevia/webroot/python_doc/primarycare_json_v1.0.txt", "OBGYN": "/opt/lampp/htdocs/allevia/webroot/python_doc/primarycare_json_v1.0.txt", 
                                   "ORTHO":"/opt/lampp/htdocs/allevia/webroot/python_doc/orthopedics_json_v1.0.txt"}
    if specialization in specialization_to_filename:
        # Has the following example format: {disease1: {symptom1: { "Power": 0.3, "Prevalence": 0.5, "Type": "RISK" }, symptom2: ...}, disease2: ...}
        with open(specialization_to_filename[specialization],'r') as handle:
            acute_symptoms = json.loads(handle.read())
    else:
        # Has the following example format: {disease1: {symptom1: { "Power": 0.3, "Prevalence": 0.5, "Type": "RISK" }, symptom2: ...}, disease2: ...}
        with open(specialization_to_filename["GEN"],'r') as handle:
            acute_symptoms = json.loads(handle.read())        
        
    # Has the following example format: {disease1: 0.2, disease2: 0.5, disease3: 0.1 ,...}
    with open('/opt/lampp/htdocs/allevia/webroot/python_doc/acute_prevalencejson.txt','r') as handle:
        acute_prevalence = json.loads(handle.read())
        
    # Synonyms generated from free thesaurus. Helps to standardize. Very naive implementation.
    with open('/opt/lampp/htdocs/allevia/webroot/python_doc/saved_synonymsjson.txt','r') as handle:
        synonyms = json.loads(handle.read())#, cls = SetDecoder) 
        
    # Converts technical terms to layman terms.
    with open('/opt/lampp/htdocs/allevia/webroot/python_doc/technical_to_laymanjson.txt','r') as handle:
        technical_to_layman = json.loads(handle.read())#, cls = SetDecoder)   
    
    # Converting from list to set.
    for key in synonyms.keys():
        synonyms[key] = set(synonyms[key])
    for key in technical_to_layman.keys():
        technical_to_layman[key] = set(technical_to_layman[key])        
    
    # Special cases.
    synonyms['sputum'].remove('mucus')
    synonyms['no sputum'].remove('no mucus')
    
    
    ordered_symptoms = order_symptoms(acute_symptoms)
    
    # Changing into a set.
    current_symptoms = set([])
    for j in current_symptoms_input:
        i1 = j.lower()
        if i1 != '':
            current_symptoms.add(i1.strip(' '))

    # Changes current symptoms into all technical words
    for i in synonyms.keys(): 
        for j in synonyms[i]:
            go = False # Controls whether or not a symptom is among the ones we have.
            if len(i) > 2 and 'no ' != i[:3]:
                positive_flag = True
            else:
                positive_flag = False
                
            # See if anything in current symptoms is in the synonyms of this particular i symptom.
            for symp in current_symptoms:
                if j in symp and positive_flag == False:
                    current_symptoms.remove(symp)
                    go = True
                    break
                elif j in symp and positive_flag == True:
                    go = True
                    current_symptoms.remove(symp)
                    if sum([k in symp for k in ['no ', 'not ','negative ']]) > 0:
                        i = 'no ' + i
                    break
                        
                    
            
            # Really messy way of removing symptoms that the patient currently has
            # from the list of symptoms prompted.
            if go == True:
                if len(i) > 2:
                    if 'no ' != i[:3]:
                        current_symptoms.add(i)
                        for disease in ordered_symptoms.keys():
                            if i in ordered_symptoms[disease]:
                                ordered_symptoms[disease].remove(i)
                            if 'no ' in i and i[3:] in ordered_symptoms[disease]:
                                ordered_symptoms[disease].remove(i[3:])
                            elif 'no ' + i in ordered_symptoms[disease]:
                                ordered_symptoms[disease].remove('no ' + i)
                    else:
                        current_symptoms.add(i)
                        for disease in ordered_symptoms.keys():
                            if i in ordered_symptoms[disease]:
                                ordered_symptoms[disease].remove(i)
                            if 'no ' in i and i[3:] in ordered_symptoms[disease]:
                                ordered_symptoms[disease].remove(i[3:])
                            elif 'no ' + i in ordered_symptoms[disease]:
                                ordered_symptoms[disease].remove('no ' + i)
                else:
                    current_symptoms.add(i)
                    for disease in ordered_symptoms.keys():
                        if i in ordered_symptoms[disease]:
                            ordered_symptoms[disease].remove(i)
                        if 'no ' in i and i[3:] in ordered_symptoms[disease]:
                            ordered_symptoms[disease].remove(i[3:])
                        elif 'no ' + i in ordered_symptoms[disease]:
                            ordered_symptoms[disease].remove('no ' + i)
                        

                
    #print 'current symptoms ', current_symptoms
    pval_dict = compute_logp(current_symptoms, acute_symptoms, acute_prevalence)

    # Finding disease with maximum probability
    current_top_disease = [i for i,j in pval_dict.items() if j == max(pval_dict.values())][0]
    
    # Symptom ordering, without current symptoms and their associated 'no '
    all_asked_symptoms, counter = [], 0
    potential_asked_symptoms = [ordered_symptoms[current_top_disease][i] if 'no ' not in ordered_symptoms[current_top_disease][i] else ordered_symptoms[current_top_disease][i][3:] for i in range(len(ordered_symptoms[current_top_disease]))]
    for symptom in potential_asked_symptoms:
        if symptom not in all_asked_symptoms:
            all_asked_symptoms.append(symptom)
            counter += 1
        if counter >= 7:
            break
        
    ###### tbh not sure what's going on here with the original thinking
    #counter = 0
    #while len(all_asked_symptoms) < 5 and counter < 8 and len(ordered_symptoms[current_top_disease]) > counter:
    #    potential_asked_symptom = [ordered_symptoms[current_top_disease][counter] if 'no ' not in ordered_symptoms[current_top_disease][counter] else ordered_symptoms[current_top_disease][counter][3:]][0]
    #    if potential_asked_symptom not in all_asked_symptoms:        
    #        all_asked_symptoms.append(potential_asked_symptom)
    #    counter += 1
        
    #old version asked_symptom = [ordered_symptoms[current_top_disease][0] if 'no ' not in ordered_symptoms[current_top_disease][0] else ordered_symptoms[current_top_disease][0][3:]][0]#remember not to ask 'no '
    #speak, see if its in layman
    #old version asked_symptom2 = [ordered_symptoms[current_top_disease][1] if 'no ' not in ordered_symptoms[current_top_disease][1] else ordered_symptoms[current_top_disease][1][3:]][0]#remember not to ask 'no '
    #old version if asked_symptom == asked_symptom2:
    #old version     asked_symptom2 = [ordered_symptoms[current_top_disease][2] if 'no ' not in ordered_symptoms[current_top_disease][2] else ordered_symptoms[current_top_disease][2][3:]][0]#remember not to ask 'no '

    #print asked_symptom, current_top_disease
    all_asked_symptoms_layman = []
    for i in all_asked_symptoms:
        all_asked_symptoms_layman.append([i if i not in technical_to_layman.keys() else list(technical_to_layman[i])[0]][0])

    return {'layman':all_asked_symptoms_layman,'technical':all_asked_symptoms}
    #return {'layman': ['superficial','localized'],'technical': ['superficial','localized']}
    #return {'layman': [' muscle pain','headache','cough','fever','stuffy nose'],'technical': ['myalgia', 'headache', 'cough', 'fever', 'nasal congestion']}

def compute_logp(symptoms_set, symptoms_dict, disease_prev):
    '''
    Computes logp value for each disease in symptoms_dict.
    Inputs:
        symptoms_set - set of symptoms in technical terms.
        symptoms_dict - acute_symptoms kind of set up. {disease1: {symptom1: { "Power": 0.3, "Prevalence": 0.5, "Type": "RISK" }, symptom2: ...}, disease2: ...}
        disease_prev - acute_prevalence kind of set up. {disease1: 0.2, disease2: 0.5, disease3: 0.1 ,...}
    Outputs: 
        diseases - log pvals for each disease.
    '''
    diseases = {}

    for i in symptoms_dict.keys():
        # Sometimes the prevalence file isn't as updated as the symptoms file.
        # Resulting in missing diseases.
        if i in disease_prev and np.isnan(disease_prev[i]) == False:
            diseases[i] = np.log(disease_prev[i]/(1-disease_prev[i]))
        else:
            # If we don't have the prevalence, then we assume a small prevalence.
            diseases[i] = np.log(0.001/(1-0.001))
        for symptom in symptoms_set:
            if symptom in symptoms_dict[i].keys():
                
                # If we have the likelihood ratio then we use it. If not, we use 1.
                # The interpretation of 1 is that it neither increases nor decreases the probability of a particular disease.
                if np.isnan(symptoms_dict[i][symptom]['power']) == False:
                    #print i, symptom, symptomsdict[i][symptom]['power']
                    diseases[i] += np.log(abs(symptoms_dict[i][symptom]['power']))
                
    #print diseases
    for k in diseases.keys():
        diseases[k] = np.e**diseases[k] / (1 + np.e**diseases[k])
    #print([(i, j) for i,j in diseases.items() if j > 0.001])
    return diseases

def order_symptoms(symptoms_dict):
    '''
    Orders symptoms by likelihoodratio*prevalence of symptom within disease.
    {disease:[ordered symptoms]}
    Inputs: acute_symptoms kind of setup
    Outputs: {disease1:[ordered symptoms for disease1],disease2:[ordered symptoms for disease2]}
    '''
    ordering = {}
    for disease in symptoms_dict.keys():
        ordering[disease] = []
        temp_order = []
        for symptom in symptoms_dict[disease].keys():
            # If prevalence does not exist then we assume 0.01
            if np.isnan(symptoms_dict[disease][symptom]['prevalence']):
                temp_order.append((symptom,0.01 * symptoms_dict[disease][symptom]['power']))
            else:            
                temp_order.append((symptom,symptoms_dict[disease][symptom]['prevalence'] * symptoms_dict[disease][symptom]['power']))
        ordering[disease] = [i[0] for i in sorted(temp_order,key=lambda symp:[symp[1] if np.isnan(symp[1]) == False else 0][0],reverse=True)]
    return ordering
#print json.dumps(['hi','ho'])
#print php_param
#print json.dumps(type(php_param))
print(json.dumps(symptom_prompting(php_param, spec)))
#print json.dumps(php_param)
#print symptom_prompting(['myalgia'])