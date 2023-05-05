function checkForm(id, error) {

    //debugger;

const form = document.querySelector(id);
let errorSpan = document.getElementById(error);

form.addEventListener('submit', (event) => {
    let field = form.querySelectorAll('input, select, textarea');
    let hasEmptyFields = false;
    let invalidName = false;
    let invalidEmail = false;
    let invalidCardNumber = false;
    let invalidSecCode = false;
    let invalidExpiry = false;
    let tooLong = false;
    let invalidDelete = false;
    let errorMessage = "";

    field.forEach(field => {
        field.value = field.value.trim();
    
        if (!field.classList.contains('optional')) {

            if (field.value === '' || field.value === null) {
                hasEmptyFields = true;
                field.style.borderWidth = "2px";
                field.style.borderColor = "#FF0000";
            } else {
                field.style.borderWidth = "1px";
                field.style.borderColor = "#000000";
            }
        
            if (field.classList.contains('name')) {
                if (inValidName(field.value)) {
                    invalidName = true;
                    field.style.borderColor = "#FF0000";
                    field.style.borderWidth = "2px";
                } else {
                    field.style.borderWidth = "1px";
                    field.style.borderColor = "#000000";
                }
            }
        
            if (field.classList.contains('email')) {
                if (inValidEmail(field.value)) {
                    invalidEmail = true;
                    field.style.borderColor = "#FF0000";
                    field.style.borderWidth = "2px";
                } else {
                    field.style.borderWidth = "1px";
                    field.style.borderColor = "#000000";
                }
            }

            if (field.classList.contains('cardNumber')) {

                if (inValidCardNumber(field.value)) {
                    invalidCardNumber = true;
                    field.style.borderColor = "#FF0000";
                    field.style.borderWidth = "2px";
                } else {
                    field.style.borderWidth = "1px";
                    field.style.borderColor = "#000000";
                }
            }

            if (field.classList.contains('secCode')) {
                if (inValidSecCode(field.value)) {
                    invalidSecCode = true;
                    field.style.borderColor = "#FF0000";
                    field.style.borderWidth = "2px";
                } else {
                    field.style.borderWidth = "1px";
                    field.style.borderColor = "#000000";
                }
            }

            if (field.classList.contains('expiry')) {
                if (inValidExpiry(field.value)) {
                    invalidSecCode = true;
                    field.style.borderColor = "#FF0000";
                    field.style.borderWidth = "2px";
                } else {
                    field.style.borderWidth = "1px";
                    field.style.borderColor = "#000000";
                }
            }

            if (field.classList.contains('tiny')) {
                if (checkLengthValidation(field.value, 8)) {
                    tooLong = true;
                }
            }

            if (field.classList.contains('small')) {
                if (checkLengthValidation(field.value, 32)) {
                    tooLong = true;
                }
            }

            if (field.classList.contains('med')) {
                if (checkLengthValidation(field.value, 100)) {
                    tooLong = true;
                }
            }

            if (field.classList.contains('long')) {
                if (checkLengthValidation(field.value, 500)) {
                    tooLong = true;
                }
            }

            if (field.classList.contains('delete')) {
                if (checkDelete(field.value)) {
                    invalidDelete = true;
                }
            }

        }

    });

    if (invalidEmail || invalidName || hasEmptyFields || invalidCardNumber || invalidSecCode || invalidExpiry || tooLong || invalidDelete) {
        errorMessage += "Cannot proceed: ";

        if (invalidName) {
            errorMessage += " -- Invalid Name(s)";
        }

        if (invalidEmail) {
            errorMessage += " -- Invalid Email";
        }

        if (hasEmptyFields) {
            errorMessage += " -- Some fields missing";
        }

        if (tooLong) {
            errorMessage += " -- Character length exceeded";
        }

        if (invalidCardNumber || invalidSecCode || invalidExpiry) {
            errorMessage += " -- Invalid card details";
        }

        if(invalidDelete) {
            errorMessage += " -- You must enter 'DELETE'";
        }

        event.preventDefault();
        errorSpan.innerHTML = errorMessage;
        errorSpan.style.color = "#FF0000";
    }

    if (document.getElementById('inValidPasswordMatch') != null) {
        if(document.getElementById('inValidPasswordMatch').innerHTML != "Looks Good") {
            event.preventDefault();
        }
    }

    if (document.getElementById('confirmInValidPasswordMatch') != null) {
        if(document.getElementById('confirmInValidPasswordMatch').innerHTML != "Looks Good") {
            event.preventDefault();
        }
    }

});

}

function inValidName(array) {
    const pattern = /^(?!.[-']{2,})(?=.[-']?[a-zA-Z]{1,31}[a-zA-Z])[a-zA-Z\s'-]{1,32}$/;
    if (!pattern.test(array)) {
        return true;
    } else {
        return false;
    }
}

function inValidEmail(array) {
    const pattern = /^([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})$/;
    if (!pattern.test(array)) {
        return true;
    } else {
        return false;
    }
}

function inValidCardNumber(array) {
    const pattern = /^\d{16}$/;
    if (!pattern.test(array)) {
        return true;
    } else {
        return false;
    }
}

function inValidSecCode(array) {
    const pattern = /^\d{3}$/;
    if (!pattern.test(array)) {
        return true;
    } else {
        return false;
    }
}

function inValidExpiry(array) {
    const pattern = /^(0[1-9]|1[0-2])\/\d{2}$/;
    if (!pattern.test(array)) {
        return true;
    } else {
        return false;
    }
}

function inValidPassword(id1, id2, spanID, size) {
    const pattern = new RegExp(`^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[^a-zA-Z0-9])[a-zA-Z\\d\\W]{7,${size}}$`);
    const field1 = document.getElementById(id1);
    const field2 = document.getElementById(id2);
    const message = document.getElementById(spanID);

        if (!pattern.test(field1.value)) {
            message.style.color = "#FF0000";
            message.innerHTML = "Too weak"
        } else if (field1.value != field2.value) {
            message.style.color = "#FF0000";
            message.innerHTML = "Passwords do not match";
        } else if (field1.value == field2.value) {
            message.style.color = "#00FF00";
            message.innerHTML = "Looks Good";
        }
}

function checkDelete(array) {

    if (array != 'DELETE') {
        return true;
    } else {
        return false;
    }
}

// function passwordMatch(id1, id2, spanID) {
//     const pattern = new RegExp(`^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[^a-zA-Z0-9])[a-zA-Z\\d\\W]{7,${size}}$`);
//     const field1 = document.getElementById(id1);
//     const field2 = document.getElementById(id2);
//     const message = document.getElementById(spanID);

//      if (field1.value == field2.value){
//         message.style.color = "#00FF00";
//         message.innerHTML = "Looks Good";
//     }
// }


function checkLengthFeedback(id, spanID, size) {
    const pattern = new RegExp(`^.{0,${size}}$`);
    const field = document.getElementById(id);
    const message = document.getElementById(spanID);
    if (!pattern.test(field.value)) {
        message.style.color = "#FF0000";
        message.innerHTML = "Too many characters"
    } else {
        message.innerHTML = "";
    }
}

function checkLengthValidation(array, size) {
    const pattern = new RegExp(`^.{0,${size}}$`);
    if (!pattern.test(array)) {
        return true;
    } else {
        return false;
    }
}

function checkAdminID(formID, adminID, error) {

    const form = document.querySelector(formID);
    let errorSpan = document.getElementById(error);

    form.addEventListener('submit', (event) => {
        let field = form.querySelectorAll('input, select, textarea');
        let errorMessage = "";
        let invalidID = false;

        field.forEach(field => {
            field.value = field.value.trim();
        
            if (field.classList.contains('optional')) {

                if(field.value != adminID) {
                    invalidID = true;
                }
            }

        });

        if (invalidID) {
            errorMessage += "Cannot proceed: ";

            if(invalidID) {
                errorMessage += "Incorrect Administrator ID";
            }

            event.preventDefault();
            errorSpan.innerHTML = errorMessage;
            errorSpan.style.color = "#FF0000";
        }
    });

}