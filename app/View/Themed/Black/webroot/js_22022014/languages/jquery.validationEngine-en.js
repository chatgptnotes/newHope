
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                   // "alertText": "* This field is required",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },
                "minUsernameSize": {
                    "regex": /^.{4,10}$/,
                    "alertText": "* Minimum ",
                    "alertText2": " characters allowed"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Minimum ",
                    "alertText2": " characters allowed"
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "* Maximum ",
                    "alertText2": " characters allowed"
                },
                "min": {
                    "regex": /(\s*(\S)\s*){8,}/,
                    "alertText": "* Minimum value is 8"
                },
                "max": {
                    "regex": "none",
                    "alertText": "* Maximum value is "
                },
                "past": {
                    "regex": "none",
                    "alertText": "* Date prior to "
                },
                "future": {
                    "regex": "none",
                    "alertText": "* Date past "
                },	
                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* Checks allowed Exceeded"
                },
                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* Please select ",
                    "alertText2": " options"
                },
                "equals": {
                    "regex": "none",
                    "alertText": "* Fields do not match"
                },
              //rules for password-Aditya Chitmitwar
                "passwordOnly": {
                    "regex": /^[a-zA-Z \-,.()$@!#*_]*$/,
                    "alertText": "* Please enter special character [-,.()$@!#*_]"
                },
                "userNameOnly": {
                    "regex": /^\S+\w{6,}/,
                    "alertText": "* Please enter username with atleast 6 character with out space"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Invalid phone number"
                },
                "bp": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \\])?([\(]{1}[0-9]{2,6}[\)])?([0-9 ]{3,20}[\//\/]?[0-9 ]{1,3})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Invalid BP"
                },
                "email": {
                    // Simplified, was not working in the Iphone browser
                    "regex": /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/,
                    "alertText": "* Invalid email address"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* Not a valid integer"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid floating decimal number"
                },
                "onlyNumber": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^(\+?((([0-9]+(\.)?)|([0-9]*\.[0-9]+))([eE][+-]?[0-9]+)?))$/,
                    "alertText": "* Numbers only"
                },
                "date": {
                    "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/,
                    "alertText": "* Invalid date, must be in YYYY-MM-DD format"
                },
                "ipv4": {
                    "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Invalid IP address"
                },
                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/,
                    "alertText": "* Invalid URL"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Numbers only"
                },
                "onlyNumberLandLine": {
                	//accepts number and '()-'
                    "regex": /^[0-9\ \'\(\)\-]+$/,
                    "alertText": "* Invalid LandLine number"
                },
                "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* Letters only"
                },
                "onlyLetterSpCh": {
                    "regex": /^[ A-Za-z_@.\/#&+-]*$/,
                    "alertText": "* Valid Letters only "
                },
                "onlyLetterNumber": {
                    "regex": /^([0-9a-zA-Z\s\.]+(\W)?)+$/,
                    "alertText": "* Please enter valid name"
                },
                // --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "regex": /\S/,
                    "url": "ajaxValidateUsername",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This username is available",
                    "alertText": "* This user is already taken",
                    "alertTextLoad": "* Validating, please wait"
                }, "ajaxSmartPhraseCall": {
                    "regex": /\S/,
                    "url": "SmartPhrases/ajaxValidateSamrtPhrasename",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This Smartphrase name is available",
                    "alertText": "* This Smartphrase name is already taken",
                    "alertTextLoad": "* Validating, please wait"
                },"ajaxTestNameCall": {
                    "regex": /\S/,
                    "url": "ajaxValidateTestName",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This test name is available",
                    "alertText": "* This test name is already taken",
                    "alertTextLoad": "* Validating, please wait"
                },"ajaxCheckDupRole": {
                    "regex": /\S/,
                    "url": "checkduprole",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This role is available",
                    "alertText": "* This role is already taken",
                    "alertTextLoad": "* Validating, please wait"
                },"ajaxUserCallPhp": {
                    "url": "phpajax/ajaxValidateFieldUser.php",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This username is available",
                    "alertText": "* This user is already taken",
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxNameCall": {
                    // remote json service location
                    "url": "ajaxValidateFieldName",
                    // error
                    "alertText": "* This name is already taken",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This name is available",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				 "ajaxNameCallPhp": {
	                    // remote json service location
	                    "url": "phpajax/ajaxValidateFieldName.php",
	                    // error
	                    "alertText": "* This name is already taken",
	                    // speaks by itself
	                    "alertTextLoad": "* Validating, please wait"
	                },
                "facilityname": {
                    "regex": /\S/,
                    "alertText": "* Please select hospital name"
                },
                "customname": {
                    "regex": /\S/,
                    "alertText": "* Please enter name"
                },
                "customaddress1": {
                    "regex": /\S/,
                    "alertText": "* Please enter address"
                },
                "customzipcode": {
                    "regex": /\S/,
                    "alertText": "* Please enter zip"
                },
                "customcity": {
                    "regex": /\S/,
                    "alertText": "* Please select city"
                },
                "customstate": {
                    "regex": /\S/,
                    "alertText": "* Please select state"
                },
                "customcountry": {
                    "regex": /\S/,
                    "alertText": "* Please select country"
                },
                "customemail": {
                    "regex": /\S/,
                    "alertText": "* Please enter email"
                },
                "customphone1": {
                    "regex": /\S/,
                    "alertText": "* Please enter phone"
                },
                "custommobile": {
                    "regex": /\S/,
                    "alertText": "* Please enter mobile"
                },
                "customfax": {
                    "regex": /\S/,
                    "alertText": "* Please enter fax"
                },
                "customcontactperson": {
                    "regex": /\S/,
                    "alertText": "* Please enter contact person"
                },
                "custommaxlocations": {
                    "regex": /\S/,
                    "alertText": "* Please enter maximum location"
                },
                "custominitial": {
                    "regex": /\S/,
                    "alertText": "* Please select initial"
                },
                "customfirstname": {
                    "regex": /\S/,
                    "alertText": "* Please enter first name"
                },
                "custommiddlename": {
                    "regex": /\S/,
                    "alertText": "* Please enter middle name"
                },
                "customlastname": {
                    "regex": /\S/,
                    "alertText": "* Please enter last name"
                },"rolename": {
                    "regex": /\S/,
                    "alertText": "* Please enter role name"
                },"location_id": {
                    "regex": /\S/,
                    "alertText": "* Please select location"
                },"hasspecility": {
                    "regex": /\S/,
                    "alertText": "* Please select speciality"
                },"countryname": {
                    "regex": /\S/,
                    "alertText": "* Please select country."
                },"statename": {
                    "regex": /\S/,
                    "alertText": "* Please enter valid state name"
                },"cities_statename": {
                    "regex": /\S/,
                    "alertText": "* Please select state"
                },"cityname": {
                    "regex": /\S/,
                    "alertText": "* Please enter valid city name"
                },"customroles": {
                    "regex": /\S/,
                    "alertText": "* Please select role"
                },
                "customlocations": {
                    "regex": /\S/,
                    "alertText": "* Please select location"
                },"patient_gender": {
                    "regex": /\S/,
                    "alertText": "* Please select sex"
                },"patient_first_name": {
                    "regex": /\S/,
                    "alertText": "* Please enter first name"
                },"patient_last_name": {
                    "regex": /\S/,
                    "alertText": "* Please enter last name"
                },"patient_dob": {
                    "regex": /\S/,
                    "alertText": "* Please enter date of birth"
                },"AdmissionTypeOPD": {
                    "regex": /\S/,
		    "alertText": "* Please select patient's Registration type."
                },"customrequired": {
                    "regex": /\S/,
                    "alertText": "* This field is required"
                },"patient_title": {
                    "regex": /\S/,
                    "alertText": "* Please select title"
                },"patient_city": {
                    "regex": /\S/,
                    "alertText": "* Please enter city"
                },"patient_zip": {
                    "regex": /\S/,
                    "alertText": "* Please enter zip"
                },"patient_state": {
                    "regex": /\S/,
                    "alertText": "* Please enter state"
                },"patient_country": {
                    "regex": /\S/,
                    "alertText": "* Please select country"
                },"AdmissionTypeOPD": {
                    "regex": /\S/,
                    "alertText": "* Please select Registration type"
                },"patient_address1": {
                    "regex": /\S/,
                    "alertText": "* Please enter address"
                },"customroles": {
                    "regex": /\S/,
                    "alertText": "* Please select role"
                },"customlocname": {
                    "regex": /\S/,
                    "alertText": "* Please enter location name"
                },"name": {
                    "regex": /\S/,
                    "alertText": "* Please enter name"
                },"mandatory-enter": {
                    "regex": /\S/,
                    "alertText": "* Please enter value"
                },"mandatory-select": {
                    "regex": /\S/,
                    "alertText": "* Please select"
                },"mandatory-date": {
                    "regex": /\S/,
                    "alertText": "* Please enter date"
                },"mandatory-time": {
                    "regex": /\S/,
                    "alertText": "* Please enter time"
                },"Wardname": {
                    "regex": /\S/,
                    "alertText": "* Please enter ward name"
                },"Wardid": {
                    "regex": /\S/,
                    "alertText": "* Please enter ward id"
                },"no_of_rooms": {
                    "regex": /\S/,
                    "alertText": "* Please enter no of rooms"
                },"bed_prefix": {
                    "regex": /\S/,
                    "alertText": "* Please enter bed prefix"
                }
                ,"customdepartment": {
                    "regex": /\S/,
                    "alertText": "* Please select department"
                },"customeducation": {
                    "regex": /\S/,
                    "alertText": "* Please enter education"
                },"customhaspecility": {
                    "regex": /\S/,
                    "alertText": "* Please select speciality"
                },"customspecility_keyword": {
                    "regex": /\S/,
                    "alertText": "* Please enter speciality keyword"
                },"customexperience": {
                    "regex": /\S/,
                    "alertText": "* Please enter experience"
                },"customprofile_description": {
                    "regex": /\S/,
                    "alertText": "* Please enter profile description"
                },"customdateofbirth": {
                    "regex": /\S/,
                    "alertText": "* Please select date of birth"
                },"starttime": {
                    "regex": /\S/,
                    "alertText": "* Please enter start time"
                },"endtime": {
                    "regex": /\S/,
                    "alertText": "* Please enter end time"
                },"customhospitalname": {
                    "regex": /\S/,
                    "alertText": "* Please enter hospital name"
                },"customcharges": {
                    "regex": /\S/,
                    "alertText": "* Please enter charges"
                },"customavailability": {
                    "regex": /\S/,
                    "alertText": "* Please select availability"
                },"customage": {
                    "regex": /\S/,
                    "alertText": "* Please enter notes"
                },"customage": {
                    "regex": /\S/,
                    "alertText": "* Please enter age"
                },"customdescription": {
                    "regex": /\S/,
                    "alertText": "* Please enter description"
                },"noOfBeds": {
                    "regex": /\S/,
                    "alertText": "* Please enter number of beds"
                },"roomName": {
                    "regex": /\S/,
                    "alertText": "* Please enter room name"
                },"customnotes": {
                    "regex": /\S/,
                    "alertText": "* Please enter notes"
                },"customfacilities": {
                    "regex": /\S/,
                    "alertText": "* Please select hospital"
                },"number": {
                    "regex": /\S/,
                    "alertText": "* Please enter number"

                },"categorycode": {
                    "regex": /\S/,
                    "alertText": "* Please enter category code"
                },"quantity": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Please enter quantity in number"
                },"itemcategory": {
                    "regex": /\S/,
                    "alertText": "* Please enter category"
                },"itemcode": {
                    "regex": /\S/,
                    "alertText": "* Please enter item code"
                },"itemtype": {
                    "regex": /\S/,
                    "alertText": "* Please select type"
                },"itemquantity": {
                    "regex": /\S/,
                    "alertText": "* Please enter quantity"
                },"customcolorcode": {
                    "regex": /\S/,
                    "alertText": "* Please enter color code"

                },"wardselect": {
                    "regex": /\S/,
                    "alertText": "* Please select ward."

                },"woundlocation": {
                    "regex": /\S/,
                    "alertText": "* Please enter wound location"

                },"microorganism1": {
                    "regex": /\S/,
                    "alertText": "* Please enter micro organism 1"

                },"microorganism2": {
                    "regex": /\S/,
                    "alertText": "* Please enter micro organism 2"

                },"lastcontact": {
                    "regex": /\S/,
                    "alertText": "* Please select last date of contact"

                },"designation": {
                    "regex": /\S/,
                    "alertText": "* Please select designation"

                },"rptfrom": {
                    "regex": /\S/,
                    "alertText": "* Please click on calender image and select date"

                },"rptto": {
                    "regex": /\S/,
                    "alertText": "* Please click on calender image and select date"

                },"categorycode": {
                    "regex": /\S/,
                    "alertText": "* Please enter category code"

                },"categoryname": {
                    "regex": /\S/,
                    "alertText": "* Please enter category name"

                },"timeselect": {
                    "regex": /\S/,
                    "alertText": "* Please select time."

                },"dateSelect": {
                    "regex": /\S/,
                    "alertText": "* Please select date."

                },"mandatory-enter-only": {
                    "regex": /\S/,
                    "alertText": "* Please enter"
                },"customalias": {
                    "regex": /\S/,
                    "alertText": "* Please enter alias"
                },"passrequired": {
                    "regex": /\S/,
                    "alertText": "* Please enter current password"
                },"newpassrequired": {
                    "regex": /\S/,
                    "alertText": "* Please enter new password"
                }

            };
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);