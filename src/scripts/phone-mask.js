// ################################################ //
// ################################################ //

// Brazil - Phone Mask
// Description: Brazilian phone number with DDD and optional mobile '9'.
// Formats:
// - Landline: (DD) XXXX-XXXX (10 digits)
// - Mobile:   (DD) 9 XXXX-XXXX (11 digits)
// Example: (11) 9 1234-5678

document.getElementById('phone').addEventListener('input', function (e) {
    let input = e.target;
    let value = input.value.replace(/\D/g, ''); // Remove tudo o que não for número

    if (value.length <= 2) {
        input.value = value; // Apenas o DDD
    } else if (value.length <= 6) {
        input.value = `(${value.slice(0, 2)}) ${value.slice(2)}`; // DDD + primeiro parte do número
    } else if (value.length <= 10) {
        // Landline formatting (10 digits): (DD) XXXX-XXXX
        input.value = `(${value.slice(0, 2)}) ${value.slice(2, 6)}-${value.slice(6, 10)}`;
    } else {
        // Mobile formatting (11 digits): (DD) 9 XXXX-XXXX
        input.value = `(${value.slice(0, 2)}) ${value.slice(2, 3)} ${value.slice(3, 7)}-${value.slice(7, 11)}`;
    }
    if (value.length > 11) {
        input.value = input.value.slice(0, 19); // cap visual length
    }
});

// ################################################ //
// ################################################ //

// Argentina - Phone Mask
// Description: Argentine number with area code and subscriber.
// Format: +54 (AA) XXXX-XXXX (10 digits)
// Example: +54 (11) 1234-5678

var phoneAr = document.getElementById('phone_ar');
if (phoneAr) {
    phoneAr.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 2) {
            input.value = `+54 (${value}`;
        } else if (value.length <= 6) {
            input.value = `+54 (${value.slice(0, 2)}) ${value.slice(2)}`;
        } else {
            input.value = `+54 (${value.slice(0, 2)}) ${value.slice(2, 6)}-${value.slice(6, 10)}`;
        }
        if (value.length > 10) {
            input.value = `+54 (${value.slice(0, 2)}) ${value.slice(2, 6)}-${value.slice(6, 10)}`;
        }
    });
}

// ################################################ //
// ################################################ //

// USA - Phone Mask
// Description: NANP standard formatting.
// Format: (AAA) BBB-CCCC (10 digits)
// Example: (415) 555-2671

var phoneUs = document.getElementById('phone_us');
if (phoneUs) {
    phoneUs.addEventListener('input', function (e) {
        let input = e.target;
        let v = input.value.replace(/\D/g, '');
        if (v.length <= 3) {
            input.value = `(${v}`;
        } else if (v.length <= 6) {
            input.value = `(${v.slice(0, 3)}) ${v.slice(3)}`;
        } else {
            input.value = `(${v.slice(0, 3)}) ${v.slice(3, 6)}-${v.slice(6, 10)}`;
        }
        if (v.length > 10) {
            input.value = `(${v.slice(0, 3)}) ${v.slice(3, 6)}-${v.slice(6, 10)}`;
        }
    });
}

// ################################################ //
// ################################################ //

// Portugal - Phone Mask
// Description: Portuguese national format, grouped in threes.
// Format: +351 ### ### ### (9 digits)
// Example: +351 912 345 678

var phonePt = document.getElementById('phone_pt');
if (phonePt) {
    phonePt.addEventListener('input', function (e) {
        let input = e.target;
        let v = input.value.replace(/\D/g, '');
        if (v.length <= 3) {
            input.value = `+351 ${v}`;
        } else if (v.length <= 6) {
            input.value = `+351 ${v.slice(0, 3)} ${v.slice(3)}`;
        } else {
            input.value = `+351 ${v.slice(0, 3)} ${v.slice(3, 6)} ${v.slice(6, 9)}`;
        }
        if (v.length > 9) {
            input.value = `+351 ${v.slice(0, 3)} ${v.slice(3, 6)} ${v.slice(6, 9)}`;
        }
    });
}

// ################################################ //
// ################################################ //

// Spain - Phone Mask
// Description: Spanish national format, grouped in threes.
// Format: +34 ### ### ### (9 digits)
// Example: +34 612 345 678

var phoneEs = document.getElementById('phone_es');
if (phoneEs) {
    phoneEs.addEventListener('input', function (e) {
        let input = e.target;
        let v = input.value.replace(/\D/g, '');
        if (v.length <= 3) {
            input.value = `+34 ${v}`;
        } else if (v.length <= 6) {
            input.value = `+34 ${v.slice(0, 3)} ${v.slice(3)}`;
        } else {
            input.value = `+34 ${v.slice(0, 3)} ${v.slice(3, 6)} ${v.slice(6, 9)}`;
        }
        if (v.length > 9) {
            input.value = `+34 ${v.slice(0, 3)} ${v.slice(3, 6)} ${v.slice(6, 9)}`;
        }
    });
}

// ################################################ //
// ################################################ //

// United Kingdom - Phone Mask
// Description: UK numbers commonly shown as +44 #### ### ####.
// Format: +44 #### ### #### (11 digits)
// Example: +44 2034 567 890

var phoneUk = document.getElementById('phone_uk');
if (phoneUk) {
    phoneUk.addEventListener('input', function (e) {
        let input = e.target;
        let v = input.value.replace(/\D/g, '');
        if (v.length <= 4) {
            input.value = `+44 ${v}`;
        } else if (v.length <= 7) {
            input.value = `+44 ${v.slice(0, 4)} ${v.slice(4)}`;
        } else {
            input.value = `+44 ${v.slice(0, 4)} ${v.slice(4, 7)} ${v.slice(7, 11)}`;
        }
        if (v.length > 11) {
            input.value = `+44 ${v.slice(0, 4)} ${v.slice(4, 7)} ${v.slice(7, 11)}`;
        }
    });
}

// ################################################ //
// ################################################ //

// Germany - Phone Mask
// Description: Simplified grouping for German numbers.
// Format: +49 ### ### #### (10 digits)
// Example: +49 151 234 5678

var phoneDe = document.getElementById('phone_de');
if (phoneDe) {
    phoneDe.addEventListener('input', function (e) {
        let input = e.target;
        let v = input.value.replace(/\D/g, '');
        if (v.length <= 3) {
            input.value = `+49 ${v}`;
        } else if (v.length <= 6) {
            input.value = `+49 ${v.slice(0, 3)} ${v.slice(3)}`;
        } else {
            input.value = `+49 ${v.slice(0, 3)} ${v.slice(3, 6)} ${v.slice(6, 10)}`;
        }
        if (v.length > 10) {
            input.value = `+49 ${v.slice(0, 3)} ${v.slice(3, 6)} ${v.slice(6, 10)}`;
        }
    });
}

// ################################################ //
// ################################################ //

// France - Phone Mask
// Description: French numbers formatted as +33 X XX XX XX XX.
// Format: +33 X XX XX XX XX (9 digits)
// Example: +33 6 12 34 56 78

var phoneFr = document.getElementById('phone_fr');
if (phoneFr) {
    phoneFr.addEventListener('input', function (e) {
        let input = e.target;
        let v = input.value.replace(/\D/g, '');
        if (v.length <= 1) {
            input.value = `+33 ${v}`;
        } else if (v.length <= 3) {
            input.value = `+33 ${v.slice(0,1)} ${v.slice(1)}`;
        } else if (v.length <= 5) {
            input.value = `+33 ${v.slice(0,1)} ${v.slice(1,3)} ${v.slice(3)}`;
        } else if (v.length <= 7) {
            input.value = `+33 ${v.slice(0,1)} ${v.slice(1,3)} ${v.slice(3,5)} ${v.slice(5)}`;
        } else {
            input.value = `+33 ${v.slice(0,1)} ${v.slice(1,3)} ${v.slice(3,5)} ${v.slice(5,7)} ${v.slice(7,9)}`;
        }
        if (v.length > 9) {
            input.value = `+33 ${v.slice(0,1)} ${v.slice(1,3)} ${v.slice(3,5)} ${v.slice(5,7)} ${v.slice(7,9)}`;
        }
    });
}

// ################################################ //
// ################################################ //

// South Africa - Phone Mask
// Description: South African numbers as +27 ## ### ####.
// Format: +27 ## ### #### (9 digits)
// Example: +27 82 123 4567

var phoneSa = document.getElementById('phone_sa');
if (phoneSa) {
    phoneSa.addEventListener('input', function (e) {
        let input = e.target;
        let v = input.value.replace(/\D/g, '');
        if (v.length <= 2) {
            input.value = `+27 ${v}`;
        } else if (v.length <= 5) {
            input.value = `+27 ${v.slice(0,2)} ${v.slice(2)}`;
        } else {
            input.value = `+27 ${v.slice(0,2)} ${v.slice(2,5)} ${v.slice(5,9)}`;
        }
        if (v.length > 9) {
            input.value = `+27 ${v.slice(0,2)} ${v.slice(2,5)} ${v.slice(5,9)}`;
        }
    });
}

// ################################################ //
// ################################################ //

// Nigeria - Phone Mask
// Description: Nigerian numbers commonly as +234 #### ### ####.
// Format: +234 #### ### #### (11 digits)
// Example: +234 0803 123 4567

var phoneNg = document.getElementById('phone_ng');
if (phoneNg) {
    phoneNg.addEventListener('input', function (e) {
        let input = e.target;
        let v = input.value.replace(/\D/g, '');
        if (v.length <= 4) {
            input.value = `+234 ${v}`;
        } else if (v.length <= 7) {
            input.value = `+234 ${v.slice(0,4)} ${v.slice(4)}`;
        } else {
            input.value = `+234 ${v.slice(0,4)} ${v.slice(4,7)} ${v.slice(7,11)}`;
        }
        if (v.length > 11) {
            input.value = `+234 ${v.slice(0,4)} ${v.slice(4,7)} ${v.slice(7,11)}`;
        }
    });
}