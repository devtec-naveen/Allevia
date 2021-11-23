#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Sat Jul 01 13:55:31 2017

@author: John
"""


import sys, json
import json
from pprint import pprint


# try:
  

data =  sys.argv

# sys.exit(1)
# except:
#     print(json.dumps("ERROR"))
#     sys.exit(1)

def symptom_prompting(current_symptoms_input):
   
    potential_symptoms = ["cough", "fever", "runny nose", "phlegm", "muscle soreness", 
                          "back pain", "joint pain", "hand pain", "tiredness"]
    conversions = {"runny nose": "rhinorrhea", "muscle soreness": "myalgia"}
    
    current_symptoms_input = [i.lower().strip() for i in current_symptoms_input]
    asked = [i for i in potential_symptoms if i not in current_symptoms_input and "no " + i not in current_symptoms_input]

    return {'layman':asked,'technical':[i if i not in conversions else conversions[i] for i in asked]}

# {"technical": ["rhinorrhea", "phlegm", "myalgia", "back pain", "joint pain", "hand pain", "tiredness"], "layman": ["runny nose", "phlegm", "muscle soreness", "back pain", "joint pain", "hand pain", "tiredness"]}

  
# symptom_prompting(data);
# symptom_prompting(["cough", "no fever"]);
print(json.dumps(symptom_prompting(data)))
# print(json.dumps(symptom_prompting(["cough", "no fever"])))




# {"technical": ["rhinorrhea", "phlegm", "myalgia", "back pain", "joint pain", "hand pain", "tiredness"], "layman": ["runny nose", "phlegm", "muscle soreness", "back pain", "joint pain", "hand pain", "tiredness"]}



