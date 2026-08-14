<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Patient Form</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .container {
            width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            min-height: 100px;
        }

        .loading {
            color: #777;
            font-size: 12px;
            margin-top: 5px;
        }

        button {
            padding: 10px 25px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Patient Registration</h2>

    <form action="" method="POST">

        @csrf


        {{-- Patient Name --}}
        <div class="form-group">

            <label for="patient_name">
                Patient Name
            </label>

            <input
                type="text"
                id="patient_name"
                name="patient_name"
                class="transliterate"
                placeholder="Type in English e.g. Shubham"
                autocomplete="off"
            >

        </div>


        {{-- Father Name --}}
        <div class="form-group">

            <label for="father_name">
                Father Name
            </label>

            <input
                type="text"
                id="father_name"
                name="father_name"
                class="transliterate"
                placeholder="Type in English e.g. Bhimrao"
                autocomplete="off"
            >

        </div>


        {{-- Address --}}
        <div class="form-group">

            <label for="address">
                Address
            </label>

            <textarea
                id="address"
                name="address"
                class="transliterate"
                placeholder="Type address in English"
            ></textarea>

        </div>


        <button type="submit">
            Save Patient
        </button>

    </form>

</div>


{{-- SANSCRIPT LIBRARY (CDN) --}}
<script src="https://cdn.jsdelivr.net/npm/sanscript@0.2.2/dist/sanscript.min.js"></script>


<script>

document.addEventListener("DOMContentLoaded", function () {

    const fields = document.querySelectorAll(".transliterate");


    fields.forEach(function (field) {

        let typingTimer;


        field.addEventListener("input", function () {

            const currentField = this;

            const input = currentField.value.trim();


            if (!input) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Clear previous timer
            |--------------------------------------------------------------------------
            */

            clearTimeout(typingTimer);


            /*
            |--------------------------------------------------------------------------
            | Wait 700ms after typing stops
            |--------------------------------------------------------------------------
            */

            typingTimer = setTimeout(function () {

                onlineTransliterate(
                    input,
                    currentField
                );

            }, 700);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | ONLINE TRANSLITERATION
    |--------------------------------------------------------------------------
    */

    async function onlineTransliterate(input, field) {

        try {

            const url =
                "https://inputtools.google.com/request" +
                "?text=" +
                encodeURIComponent(input) +
                "&itc=hi-t-i0-und" +
                "&num=5" +
                "&cp=0" +
                "&cs=1" +
                "&ie=utf-8" +
                "&oe=utf-8";


            const response = await fetch(url);


            if (!response.ok) {

                throw new Error(
                    "Online transliteration failed"
                );

            }


            const data = await response.json();


            /*
            |--------------------------------------------------------------------------
            | Check Google response
            |--------------------------------------------------------------------------
            */

            if (
                data &&
                data[0] === "SUCCESS" &&
                data[1] &&
                data[1][0] &&
                data[1][0][1]
            ) {

                const suggestions = data[1][0][1];


                if (suggestions.length > 0) {

                    const hindi = suggestions[0];


                    /*
                    |--------------------------------------------------------------------------
                    | Put Hindi directly inside SAME input
                    |--------------------------------------------------------------------------
                    */

                    field.value = hindi;


                    /*
                    |--------------------------------------------------------------------------
                    | Put cursor at the end
                    |--------------------------------------------------------------------------
                    */

                    field.focus();

                    field.setSelectionRange(
                        field.value.length,
                        field.value.length
                    );

                }

            } else {

                throw new Error(
                    "Invalid response"
                );

            }


        } catch (error) {

            console.warn(
                "Online transliteration failed. Using offline Sanscript.",
                error
            );


            /*
            |--------------------------------------------------------------------------
            | OFFLINE FALLBACK
            |--------------------------------------------------------------------------
            */

            try {

                // Check if Sanscript is available
                if (typeof Sanscript !== 'undefined') {

                    const hindi = Sanscript.t(
                        input,
                        "itrans",
                        "devanagari"
                    );


                    field.value = hindi;


                    /*
                    |--------------------------------------------------------------------------
                    | Cursor at end
                    |--------------------------------------------------------------------------
                    */

                    field.focus();

                    field.setSelectionRange(
                        field.value.length,
                        field.value.length
                    );

                } else {

                    console.error(
                        "Sanscript library not loaded"
                    );

                }


            } catch (offlineError) {

                console.error(
                    "Offline transliteration error:",
                    offlineError
                );

            }

        }

    }

});

</script>

</body>
</html>