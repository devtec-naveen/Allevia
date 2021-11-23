"""
This is Import of Selenium Webdrivers
    """

import time
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options


""" 
    __ASSIGN DRIVERS and DEFINE PATH__
"""
chrome_options = Options()
chrome_options.add_argument('--headless')
chrome_options.add_argument('--no-sandbox')
chrome_options.add_argument('--disable-dev-shm-usage')
#d = webdriver.Chrome('/home/PycharmProjects/chromedriver',chrome_options=chrome_options)
driver = webdriver.Chrome(executable_path="/usr/local/bin/chromedriver",chrome_options=chrome_options)
driver.maximize_window()
    # TODO



"""
    __GET URL__
"""
driver.get("https://www.allevia.md/webroot/api/micro/v1/dev/details.php")  # Admin URL
time.sleep(3)
print("URl Access in the Browser!")
    # TODO

  
"""
    __Add Medication__ 
"""

    # Click on Add Button of medication
driver_Add_Button = driver.find_element_by_xpath("//button[contains(text(),'add a medication')]").click()
time.sleep(2)


    # Click on the Enter Medication field to select from drop down
driver_medication = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[1]/div[1]/div[1]/input[1]").click()
time.sleep(1)
    # Assign the Medication to select from Drop Down
driver_dropdown = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[1]/div[1]/div[1]/ul[1]/li[3]").click()
time.sleep(1)



    # Enter the Dose Value
driver_dose = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[2]/div[1]/input[1]").send_keys("7")
time.sleep(1)


    # Click on How Often field
driver_often = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[3]/div[1]/select[1]").click()
time.sleep(1)
    # Select from Drop Down
driver_drop_down = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[3]/div[1]/select[1]/option[3]").click()
time.sleep(1)


    # Click on How is it taken Field
driver_how_it_is_taken = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[4]/div[1]/div[1]/select[1]").click()
time.sleep(1)
    # Assign the Value to how it is taken
driver_drop_down_how = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[1]/div[2]/div[4]/div[1]/div[1]/select[1]/option[5]").click()
time.sleep(1)



"""
    __Allergy__
"""

    # Click on the Allergy Button 
driver_Allergy = driver.find_element_by_xpath("//button[contains(text(),'Add a allergy')]").click()
time.sleep(1)

    # Click on the Allergy Field to enter data
driver_Allergy_Field = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[2]/div[2]/div[1]/div[1]/div[1]/input[1]").click()
time.sleep(1)
    # Enter the Text in the Field 
driver_Allergy_Text = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[2]/div[2]/div[1]/div[1]/div[1]/input[1]").send_keys("Allergic rhinitis")
time.sleep(1)


    # Click on the Reaction Field 
driver_Reaction = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[2]/div[2]/div[2]/div[1]/div[1]/div[1]/div[1]/input[1]").click()
time.sleep(1)
    # Enter The Text in the Field
driver_Reaction_Text = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[2]/div[2]/div[2]/div[1]/div[1]/div[1]/div[1]/input[1]").send_keys("immunocomplex reactions")
time.sleep(1)



"""
   __Symptom Details__
"""

    # Click on the How long have you had the cough?
driver_how_long = driver.find_element_by_xpath("//select[@id='durationcough']").click()
time.sleep(1)
    # Select the Value from Drop Down
driver_Drop_Down_hour = driver.find_element_by_xpath("//option[contains(text(),'7 days')]").click()
time.sleep(1)

    # How did the symptom start?
driver_sympton_start = driver.find_element_by_xpath("//label[@id='onsetcoughall of a suddenlabel']").click()
time.sleep(1)



"""
   __Medical History__
"""

    # Click on the Asthma
driver_Asthma = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[1]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Click on the Heart disease (coronary artery disease)
driver_Heart_disease = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[1]/div[2]/div[2]/label[1]").click()
time.sleep(.5)

    # Click on the High blood pressure (hyper_tension)
driver_High_blood_pressure = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[1]/div[2]/div[3]/label[1]").click()
time.sleep(.5)

    # Click on the Diabetes
driver_Diabetes = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[1]/div[2]/div[4]/label[1]").click()
time.sleep(.5)

    # Click on the Bleeding disorder
driver_Bleeding_disorder = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[1]/div[2]/div[5]/label[1]").click()
time.sleep(.5)



"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)



"""
   Who has the Asthma? If user Click on Asthma 
"""

    # Click on Father 
driver_Father = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[1]/label[1]").click()
time.sleep(1)

    # Click on Mother
driver_mother = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[2]/label[1]").click()
time.sleep(1)

    # Click on Paternal grandmother
driver_Paternal_grandmother = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[3]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandfather
driver_Paternal_grandfather = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[4]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandmother
driver_Maternal_grandmother = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[5]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandfather
driver_Maternal_grandfather = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[6]/label[1]").click()
time.sleep(1)

    # Click on the Brother
driver_Brother = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[7]/label[1]").click()
time.sleep(1)

    # Click on the Sister
driver_Sister = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[8]/label[1]").click()
time.sleep(1)

    # Click on the Son
driver_Son = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[9]/label[1]").click()
time.sleep(1)

    # Click On the Daughter 
driver_Daughter = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[2]/div[2]/div[10]/label[1]").click()
time.sleep(1)



"""
   Who has the Heart disease (coronary artery disease)? IF User Click on Heart Disease 
"""
    # Click on the Father
driver_Father_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[1]/label[1]").click()
time.sleep(1)

    # Click on the Mother
driver_Mother_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[2]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandmother
driver_Paternal_grandmother_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[3]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandfather
driver_Paternal_grandfather_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[4]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandmother
driver_Maternal_grandmother_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[5]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandfather
driver_Maternal_grandfather_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[6]/label[1]").click()
time.sleep(1)

    # Click on the Brother
driver_Brother_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[7]/label[1]").click()
time.sleep(1)

    # Click on the Sister
driver_Sister_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[8]/label[1]").click()
time.sleep(1)

    # Click on the Son
driver_Son_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[9]/label[1]").click()
time.sleep(1)

    # Click on the Daughter
driver_Daughter_heart = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[3]/div[2]/div[10]/label[1]").click()
time.sleep(1)




"""
    Who has the High blood pressure (hypertension)? If User click on Hypertension 
""" 

    # Click on the Father 
driver_Father_Hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[1]/label[1]").click()
time.sleep(1)

    # Click on the Mother
driver_Mother_Hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[2]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandmother
driver_Paternal_grandmother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[3]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandfather
driver_Paternal_grandfather_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[4]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandmother
driver_Maternal_grandmother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[5]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandfather
driver_Maternal_grandfather_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[6]/label[1]").click()
time.sleep(1)

    # Click on the Brother
driver_Brother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[7]/label[1]").click()
time.sleep(1)

    # Click on the Sister
driver_sister_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[8]/label[1]").click()
time.sleep(1)

    # Click on the Son
driver_son_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[9]/label[1]").click()
time.sleep(1)

    # Click on the Daughter
driver_Daughter_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[4]/div[2]/div[10]/label[1]").click()
time.sleep(1)



"""
    Who has the Diabetes? IF user Click on the Diabetes
"""
    # Click on the Father
driver_Father_Diabetes = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[1]/label[1]").click()
time.sleep(1)

    # Click on the Mother
driver_Mother_Hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[2]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandmother
driver_Paternal_grandmother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[3]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandfather
driver_Paternal_grandfather_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[4]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandmother
driver_Maternal_grandmother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[5]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandfather
driver_Maternal_grandfather_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[6]/label[1]").click()
time.sleep(1)

    # Click on the Brother
driver_Brother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[7]/label[1]").click()
time.sleep(1)

    # Click on the Sister
driver_sister_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[8]/label[1]").click()
time.sleep(1)

    # Click on the Son
driver_son_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[9]/label[1]").click()
time.sleep(1)

    # Click on the Daughter
driver_Daughter_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[5]/div[2]/div[10]/label[1]").click()
time.sleep(1)



"""
    Who has the Bleeding disorder? If User Click on that 
"""

    # Click on the Father
driver_Father_Diabetes = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[1]/label[1]").click()
time.sleep(1)

    # Click on the Mother
driver_Mother_Hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[2]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandmother
driver_Paternal_grandmother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[3]/label[1]").click()
time.sleep(1)

    # Click on the Paternal grandfather
driver_Paternal_grandfather_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[4]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandmother
driver_Maternal_grandmother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[5]/label[1]").click()
time.sleep(1)

    # Click on the Maternal grandfather
driver_Maternal_grandfather_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[6]/label[1]").click()
time.sleep(1)

    # Click on the Brother
driver_Brother_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[7]/label[1]").click()
time.sleep(1)

    # Click on the Sister
driver_sister_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[8]/label[1]").click()
time.sleep(1)

    # Click on the Son
driver_son_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[9]/label[1]").click()
time.sleep(1)

    # Click on the Daughter
driver_Daughter_hyper = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[6]/div[2]/div[10]/label[1]").click()
time.sleep(1)



''' Select the conditions you have been diagnosed with '''

    # Click on the Chronic obstructive pulmonary disease (COPD)
driver_COPD = driver.find_element_by_xpath("//label[contains(text(),'Chronic obstructive pulmonary disease (COPD)')]").click()
time.sleep(.5)

    # Click on the Asthma
driver_Asthma = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[2]/label[1]").click()
time.sleep(.5)

    # Click on the Heart disease (coronary artery disease)
driver_Heart_disease_lower = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[3]/label[1]").click()
time.sleep(.5)

    # Click on the Heart attacks
driver_Heart_attacks = driver.find_element_by_xpath("//label[contains(text(),'Heart attacks')]").click()
time.sleep(.5)

    # Click on the Heart failure
driver_Heart_failure = driver.find_element_by_xpath("//label[contains(text(),'Heart failure')]").click()
time.sleep(.5)

    # Click on the High blood pressure (hypertension) Lower 
driver_hypertension = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[6]/label[1]").click()
time.sleep(.5)

    # Click on the Diabetes
driver_Diabetes = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[7]/label[1]").click()
time.sleep(.5)

    # Click on the Chronic kidney disease
driver_Chronic_kidney_disease = driver.find_element_by_xpath("//label[contains(text(),'Chronic kidney disease')]").click()
time.sleep(.5)

    # Click on the Blood clot in lungs (pulmonary embolism)
driver_Blood_clot_in_lungs = driver.find_element_by_xpath("//label[contains(text(),'Blood clot in lungs (pulmonary embolism)')]").click()
time.sleep(.5)

    #Click on the Blood clots in legs (deep vein thrombosis [DVT])
driver_Blood_clots_in_legs = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[10]/label[1]").click()
time.sleep(.5)

    # Click on the Bleeding disorder
driver_Bleeding_disorder = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[11]/label[1]").click()
time.sleep(.5)

    # Click on the Organ transplant
driver_Organ_transplant = driver.find_element_by_xpath("//label[contains(text(),'Organ transplant')]").click()
time.sleep(.5)

    # Click on the Cancer
driver_Cancer = driver.find_element_by_xpath("//label[contains(text(),'Cancer')]").click()
time.sleep(.5)

    # Click on the Chemotherapy
driver_Chemotherapy = driver.find_element_by_xpath("//label[contains(text(),'Chemotherapy')]").click()
time.sleep(.5)

    # Click on the Cirrhosis
driver_Cirrhosis = driver.find_element_by_xpath("//label[contains(text(),'Cirrhosis')]").click()
time.sleep(.5)

    # Click on the Multiple sclerosis
driver_Multiple_sclerosis = driver.find_element_by_xpath("//label[contains(text(),'Multiple sclerosis')]").click()
time.sleep(.5)

    # Click on the Lou Gehrig's disease (ALS)
driver_Lou_Gehrigs_disease = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[17]/label[1]").click()
time.sleep(.5)

    # Click on the Myasthenia gravis
driver_Myasthenia_gravis = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[18]/label[1]").click()
time.sleep(.5)

    # Click on the Immunosuppression therapy
driver_Immunosuppression_therapy = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[7]/div[2]/div[19]/label[1]").click()
time.sleep(.5)



''' Check(Click) Out the Radio Buttons '''

    #  Do you currently smoke?
driver_Do_you_currently_smoke = driver.find_element_by_xpath("//label[@id='smokingYeslabel']").click()
time.sleep(1)
    # Select from Drop Down
driver_Smoke = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[9]/div[2]/select[1]/option[7]").click()
time.sleep(1)



"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)



    # Did you smoke in the past?
driver_Did_you_smoke_in_the_past = driver.find_element_by_xpath("//label[@id='smokingPastYeslabel']").click()
time.sleep(1)
    # Select from Drop Down week 
driver_Drop_Down_week = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[11]/div[2]/select[1]/option[7]").click()  
time.sleep(1)
    # Select from Drop Down Year 
driver_drop_down_year = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[12]/div[2]/select[1]/option[7]").click()
time.sleep(1)


    # Do you currently vape?
driver_vape = driver.find_element_by_xpath("//label[@id='vapingYeslabel']").click()
time.sleep(1)


    # Did you vape in the past?
driver_Vape_past = driver.find_element_by_xpath("//label[@id='vapingPastYeslabel']").click()
time.sleep(1)


    # Do you currently drink alcohol?
driver_alcohol = driver.find_element_by_xpath("//label[@id='etohYeslabel']").click()
time.sleep(1)
    # Select from Drop Down 
driver_drop_down_alcohol = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[16]/div[2]/select[1]/option[7]").click()
time.sleep(1)


    # Did you drink alcohol in the past? 
driver_alcohol_past = driver.find_element_by_xpath("//label[@id='etohPastYeslabel']").click()
time.sleep(1)
    # About how many drinks did you have each week?
driver_alcohol_week = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[18]/div[2]/select[1]/option[7]").click()
time.sleep(1)
    # How many years?
driver_alcohol_year = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[19]/div[2]/select[1]/option[7]").click()
time.sleep(1)


    # Are you pregnant?
driver_pregnant = driver.find_element_by_xpath("//label[@id='pregnantYeslabel']").click()
time.sleep(1)
    # How many weeks are you along?
driver_pregnant_week = driver.find_element_by_xpath("//body/div[@id='wrapper']/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[21]/div[2]/select[1]/option[8]").click()
time.sleep(1)


    # Do you have any recorded temperature readings to provide?
driver_Temp = driver.find_element_by_xpath("//label[@id='temperatureYeslabel']").click()
time.sleep(1)
    # Input your temperature reading in Fahrenheit
driver_Temp_Fehrenhiet = driver.find_element_by_xpath("//input[@id='temperatureReading']").send_keys("99")
time.sleep(1)


"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)


    # Do you have any recorded oxygenation readings to provide?
driver_oxy = driver.find_element_by_xpath("//label[@id='oxygenationYeslabel']").click()
time.sleep(1)
    # Input your oxygenation reading
driver_oxy_reading = driver.find_element_by_xpath("//input[@id='oxygenationReading']").send_keys("99")
time.sleep(1)


    # Do you have any recorded heart rates to provide?
driver_heart_rate = driver.find_element_by_xpath("//label[@id='pulseYeslabel']").click()
time.sleep(1)
    # Input your heart beats per mimute
driver_heart_rate_record = driver.find_element_by_xpath("//input[@id='pulseReading']").send_keys("99")
time.sleep(1)


    # Do you have any recorded breathing rates to provide?
driver_breathe = driver.find_element_by_xpath("//label[@id='respirationsYeslabel']").click()
time.sleep(1)
    # Input your breaths per mimute
driver_breathe_minute = driver.find_element_by_xpath("//input[@id='respirationsReading']").send_keys("99")
time.sleep(1)


    # Do you have any recorded blood pressure readings to provide?
driver_BP = driver.find_element_by_xpath("//label[@id='bloodPressureYeslabel']").click()
time.sleep(1)
    # Please enter the most recent top number (systolic) 
driver_BP_Top = driver.find_element_by_xpath("//input[@id='bloodPressureReadingTop']").send_keys("99")
time.sleep(1)
    # Please enter the most recent bottom number (diastolic)
driver_BP_Low = driver.find_element_by_xpath("//input[@id='bloodPressureReadingBottom']").send_keys("99")
time.sleep(1)



"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)

 

    # Do you have any recorded blood sugar (glucose) readings to provide?
driver_blood_sugar = driver.find_element_by_xpath("//label[@id='glucoseYeslabel']").click()
time.sleep(1)
    # Please enter your most recent glucose reading
driver_blood_sugar_read = driver.find_element_by_xpath("//input[@id='glucoseReading']").send_keys("99")
time.sleep(1)
    # Reading date
driver_blood_sugar_Date = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[35]/div[2]/input[1]").send_keys("01022020")
time.sleep(1)
    # What was the timing of this reading?
driver_blood_sugar_eat = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[36]/div[2]/select[1]/option[4]").click()
time.sleep(1)


    # Do you have any A1C results to provide?
driver_A1C = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[37]/div[2]/label[1]").click()
time.sleep(1)
    # A1C result
driver_A1C_Result = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[38]/div[2]/input[1]").send_keys("99")
time.sleep(1)


    # Height (feet)
driver_A1C_height = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[39]/div[2]/select[1]").click()
time.sleep(1)
driver_A1C_height_value =driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[40]/div[2]/select[1]/option[8]").click()
time.sleep(1)


    # Weight
driver_A1C_weight = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[41]/div[2]/input[1]").send_keys("120")
time.sleep(1)


    # Preferred pharmacy name and address
driver_pharmacy = driver.find_element_by_xpath("//input[@id='preferredPharmacy']").send_keys("xyz company")
time.sleep(1)



"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)



"""
    What is your race?
"""
    # American Indian or Alaska Native
driver_alaska = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[43]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Asian 
driver_Asian = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[43]/div[2]/div[2]/label[1]").click()
time.sleep(.5)

    # Black or African American
driver_African = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[43]/div[2]/div[3]/label[1]").click()
time.sleep(.5)

    # Caucasian
driver_Caucasian = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[43]/div[2]/div[4]/label[1]").click()
time.sleep(.5)

    # Hispanic or Latino
driver_Latino = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[43]/div[2]/div[5]/label[1]").click()
time.sleep(.5)

    # Native Hawaiian or Other Pacific Islander
driver_Hawaiian = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[4]/div[43]/div[2]/div[6]/label[1]").click()
time.sleep(.5)



"""
    COVID-19 screening questions
"""

    # Have you recently traveled outside of the United States?
driver_outside_United_States = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[5]/div[1]/div[2]/label[1]").click()
time.sleep(.5)
    # Which countries?
driver_country = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[5]/div[2]/div[2]/input[1]").send_keys("Bahamas")
time.sleep(.5)

    # Have you recently traveled to any states outside of the one you reside in?
driver_Travelled = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[5]/div[3]/div[2]/label[1]").click()
time.sleep(.5)
    # Which state(s)?
driver_state = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[5]/div[4]/div[2]/input[1]").send_keys("Honululu")
time.sleep(.5)

    # Have you been in contact with someone with a confirmed case of COVID-19?
driver_covid = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[5]/div[5]/div[2]/label[1]").click()
time.sleep(.5)

    # Are you a health care provider or first responder?
driver_provider = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[5]/div[6]/div[2]/label[1]").click()
time.sleep(.5)

    # Which of the following best describes your living situation?
driver_living = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[5]/div[7]/div[2]/label[1]").click()
time.sleep(.5)



"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)



"""
    Over the past 2 weeks, how often have you experienced the following?
"""

    # Little interest or pleasure in doing things
driver_interest = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[1]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Feeling down, depressed or hopeless
driver_hopeless = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[2]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Trouble falling or staying asleep, or sleeping too much?
driver_sleeping = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[3]/div[2]/div[1]/label[4]").click()
time.sleep(.5)


    # Feeling tired or having little energy?
driver_tired = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[4]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Poor appetite or overeating?
driver_appetite = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[5]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Feeling bad about yourself - or that you are a failure or have let yourself or your family down?
driver_Family = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[6]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Trouble concentrating on things, such as reading the newspaper or watching television?
driver_newspaper = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[7]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Moving or speaking so slowly that other people could have noticed? Or so fidgety or restless that you have been moving a lot more than usual?
driver_speaking = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[8]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Thoughts that you would be better off dead, or thoughts of hurting yourself in some way?
driver_hurting = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[9]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Feeling nervous, anxious, or on edge
driver_nervous = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[10]/div[2]/div[1]/label[4]").click()
time.sleep(.5)


"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)


    # Not being able to stop or control worrying
driver_control = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[11]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Worrying too much about different things
driver_worry = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[12]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Trouble relaxing
driver_trouble = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[13]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Being so restless it's hard to sit still
driver_restless = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[14]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Becoming easily annoyed or irritable
driver_annoyed = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[15]/div[2]/div[1]/label[4]").click()
time.sleep(.5)

    # Feeling afraid as if something awful might happen
driver_afraid = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[6]/div[16]/div[2]/div[1]/label[4]").click()
time.sleep(.5)


"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)



"""
    Do you have any of these symptoms?
"""

    # Fever
driver_fever = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[1]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Dry cough
driver_cough = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[2]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Shortness of breath
driver_shortness = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[3]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Chest pain
driver_chest = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[4]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Coughing up blood
driver_blood = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[5]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Nausea or vomiting
driver_vomiting = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[6]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Diarrhea
driver_Diarrhea = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[7]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Wet cough
driver_cough_wet = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[8]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Loss of appetite
driver_loss = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[7]/div[9]/div[2]/div[1]/label[1]").click()
time.sleep(.5)



"""
    Have you experienced any of these in the past 30 days?

"""

    # Tiredness
driver_tiredness = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[1]/div[2]/div[1]/label[1]").click()
time.sleep(.5)    

    # Chills
driver_Chills = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[2]/div[2]/div[1]/label[1]").click()
time.sleep(.5)



"""
    Scrolling of Page by Pixel 
"""
    # Scroll the Page Down
driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
time.sleep(3)



    # Runny nose
driver_nose = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[3]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Sore throat
driver_sore = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[4]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Loss of smell
driver_smell = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[5]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Loss of taste
driver_taste = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[6]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Headache
driver_Headache = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[7]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Confusion
driver_Confusion = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[8]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Decreased urine output
driver_urine = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[9]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Muscle pain
driver_pain = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[10]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Muscle pain
driver_pain = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[10]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Rashes
driver_Rashes = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[11]/div[2]/div[1]/label[1]").click()
time.sleep(.5)

    # Anxiety
driver_Anxiety = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[12]/div[2]/div[1]/label[1]").click()
time.sleep(.5)   

    # Depressed mood
driver_mood = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/div[8]/div[13]/div[2]/div[1]/label[1]").click()
time.sleep(.5) 



""" 
    Submit BUtton 
"""

    # Click on Submit Button
driver_submit = driver.find_element_by_xpath("/html[1]/body[1]/div[1]/div[1]/div[1]/div[1]/div[2]/form[1]/input[4]").click()
time.sleep(7)



"""
    __CLOSE THE BROWSER__
"""
   
driver.quit()
print("\nTest Complete Successfully!")

