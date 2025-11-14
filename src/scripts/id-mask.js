// ################################################ //
// ################################################ //

// Brazil - CPF Mask
// Description: Brazilian individual taxpayer registry number.
// Format: 000.000.000-00 (11 digits).
// Example: 123.456.789-09
// Note: Input is sanitized to digits only and punctuation is auto-inserted.
document.getElementById('cpf').addEventListener('input', function (e) {
    let input = e.target;
    let value = input.value.replace(/\D/g, ''); 

    if (value.length <= 3) {
        input.value = value; 
    } else if (value.length <= 6) {
        input.value = value.replace(/(\d{3})(\d{0,3})/, '$1.$2'); 
    } else if (value.length <= 9) {
        input.value = value.replace(/(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3'); 
    } else {
        input.value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4');
    }

    if (value.length > 11) {
        input.value = input.value.slice(0, 14); // total 14 chars
    }
});

// ################################################ //
// ################################################ //

// Brazil - CNPJ Mask
// Description: Brazilian company registry number.
// Format: 00.000.000/0000-00 (14 digits).
// Example: 12.345.678/0001-90

var cnpjEl = document.getElementById('cnpj');
if (cnpjEl) {
    cnpjEl.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 2) {
            input.value = value;
        } else if (value.length <= 5) {
            input.value = value.replace(/(\d{2})(\d{0,3})/, '$1.$2');
        } else if (value.length <= 8) {
            input.value = value.replace(/(\d{2})(\d{3})(\d{0,3})/, '$1.$2.$3');
        } else if (value.length <= 12) {
            input.value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{0,4})/, '$1.$2.$3/$4');
        } else {
            input.value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, '$1.$2.$3/$4-$5');
        }
        if (value.length > 14) {
            input.value = input.value.slice(0, 18);
        }
    });
}
// ################################################ //
// ################################################ //

// Brazil - RG Mask
// Description: Brazilian general registry (varies by state).
// Format: 00.000.000-0 (commonly 9 digits).
// Example: 12.345.678-9

var rgEl = document.getElementById('rg');
if (rgEl) {
    rgEl.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 2) {
            input.value = value;
        } else if (value.length <= 5) {
            input.value = value.replace(/(\d{2})(\d{0,3})/, '$1.$2');
        } else if (value.length <= 8) {
            input.value = value.replace(/(\d{2})(\d{3})(\d{0,3})/, '$1.$2.$3');
        } else {
            input.value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{0,1})/, '$1.$2.$3-$4');
        }
        if (value.length > 9) {
            input.value = input.value.slice(0, 12);
        }
    });
}
// ################################################ //
// ################################################ //

// Argentina - DNI Mask
// Description: National Identity Document.
// Format: 00.000.000 (8 digits).
// Example: 12.345.678

var dniArEl = document.getElementById('dni_ar');
if (dniArEl) {
    dniArEl.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 2) {
            input.value = value;
        } else if (value.length <= 5) {
            input.value = value.replace(/(\d{2})(\d{0,3})/, '$1.$2');
        } else {
            input.value = value.replace(/(\d{2})(\d{3})(\d{0,3})/, '$1.$2.$3');
        }
        if (value.length > 8) {
            input.value = input.value.slice(0, 10);
        }
    });
}
// ################################################ //
// ################################################ //

// Argentina - CUIT Mask
// Description: Taxpayer Identification Number.
// Format: 00-00000000-0 (11 digits).
// Example: 20-12345678-9

var cuitEl = document.getElementById('cuit');
if (cuitEl) {
    cuitEl.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 2) {
            input.value = value;
        } else if (value.length <= 10) {
            input.value = value.replace(/(\d{2})(\d{0,8})/, '$1-$2');
        } else {
            input.value = value.replace(/(\d{2})(\d{8})(\d{0,1})/, '$1-$2-$3');
        }
        if (value.length > 11) {
            input.value = input.value.slice(0, 13);
        }
    });
}
// ################################################ //
// ################################################ //

// USA - SSN Mask
// Description: Social Security Number.
// Format: 000-00-0000 (9 digits).
// Example: 123-45-6789
// Note: Handle with care due to sensitivity.

var ssnEl = document.getElementById('ssn');
if (ssnEl) {
    ssnEl.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 3) {
            input.value = value;
        } else if (value.length <= 5) {
            input.value = value.replace(/(\d{3})(\d{0,2})/, '$1-$2');
        } else {
            input.value = value.replace(/(\d{3})(\d{2})(\d{0,4})/, '$1-$2-$3');
        }
        if (value.length > 9) {
            input.value = input.value.slice(0, 11);
        }
    });
}
// ################################################ //
// ################################################ //

// Portugal - NIF Mask
// Description: Portuguese taxpayer number.
// Format: 000 000 000 (9 digits).
// Example: 123 456 789

var nifPtEl = document.getElementById('nif_pt');
if (nifPtEl) {
    nifPtEl.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 3) {
            input.value = value;
        } else if (value.length <= 6) {
            input.value = value.replace(/(\d{3})(\d{0,3})/, '$1 $2');
        } else {
            input.value = value.replace(/(\d{3})(\d{3})(\d{0,3})/, '$1 $2 $3');
        }
        if (value.length > 9) {
            input.value = input.value.slice(0, 11);
        }
    });
}
// ################################################ //
// ################################################ //

// Spain - DNI Mask
// Description: National ID with trailing letter.
// Format: 00000000-A.
// Example: 12345678-Z

var dniEsEl = document.getElementById('dni_es');
if (dniEsEl) {
    dniEsEl.addEventListener('input', function (e) {
        let input = e.target;
        let raw = input.value.replace(/[^0-9A-Za-z]/g, '');
        let digits = raw.replace(/[^0-9]/g, '').slice(0, 8);
        let letter = raw.replace(/[^A-Za-z]/g, '').slice(0, 1).toUpperCase();
        input.value = digits + (letter ? '-' + letter : '');
    });
}
// ################################################ //
// ################################################ //

// South Africa - ID Mask
// Description: 13-digit SA ID (YYMMDD + sequence and checksum).
// Format: 000000-0000-000 (13 digits with separators).
// Example: 901231-1234-567

var saIdEl = document.getElementById('sa_id');
if (saIdEl) {
    saIdEl.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 6) {
            input.value = value;
        } else if (value.length <= 10) {
            input.value = value.replace(/(\d{6})(\d{0,4})/, '$1-$2');
        } else {
            input.value = value.replace(/(\d{6})(\d{4})(\d{0,3})/, '$1-$2-$3');
        }
        if (value.length > 13) {
            input.value = input.value.slice(0, 15);
        }
    });
}
// ################################################ //
// ################################################ //

// Nigeria - NIN Mask
// Description: National Identification Number.
// Format: 0000 0000 000 (11 digits).
// Example: 1234 5678 901

var ninNgEl = document.getElementById('nin_ng');
if (ninNgEl) {
    ninNgEl.addEventListener('input', function (e) {
        let input = e.target;
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 4) {
            input.value = value;
        } else if (value.length <= 8) {
            input.value = value.replace(/(\d{4})(\d{0,4})/, '$1 $2');
        } else {
            input.value = value.replace(/(\d{4})(\d{4})(\d{0,3})/, '$1 $2 $3');
        }
        if (value.length > 11) {
            input.value = input.value.slice(0, 13);
        }
    });
}