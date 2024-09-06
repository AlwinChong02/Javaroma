<!DOCTYPE html>
<html>

<head>
    <title>The Generics</title>
    <meta name="description" content="This is the description">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f0f0;
        }

        .container form {
            width: 700px;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
        }

        form .row {
            display: flex;
            gap: 15px;
        }

        .row .column {
            flex: 1 1 250px;
        }

        .column .title {
            font-size: 20px;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .column .input-box {
            margin: 15px 0;
        }

        .input-box span {
            display: block;
            margin-bottom: 10px;
        }

        .input-box input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .column .flex {
            display: flex;
            gap: 15px;
        }

        .flex .input-box {
            display: flex;
            gap: 10px;
        }

        .flex .input-box {
            margin-top: 5px;
        }

        .input-box img {
            height: 34px;
            margin-top: 5px;
            filter: drop-shadow(0 0 1px #000);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #8175d3;
            border: none;
            outline: none;
            border-radius: 6px;
            font-size: 17px;
            color: #fff;
            margin-top: 5px;
            cursor: pointer;
            transition: .5s;
        }

        .btn:hover {
            background: #282532;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <form id="paymentForm">
                <div class="row">
                    <div class="column">
                        <h3 class="title">Billing Address</h3>
                        <div class="input-box">
                            <span>Full name :</span>
                            <input type="text" id="name" placeholder="Jacob Aiden" required />
                        </div>
                        <div class="input-box">
                            <span>Email :</span>
                            <input type="email" id="email" placeholder="example@gmail.com" required />
                        </div>
                        <div class="input-box">
                            <span>Address :</span>
                            <input type="text" id="address" placeholder="Room - Street - Locality" required />
                        </div>
                        <div class="input-box">
                            <span>City :</span>
                            <input type="text" id="city" placeholder="Kajang" required />
                        </div>

                        <div class="flex">
                            <div class="input-box">
                                <span>State :</span>
                                <input type="text" id="state" placeholder="Selangor" required />
                            </div>
                            <div class="input-box">
                                <span>Zip Code :</span>
                                <input type="text" id="zip" placeholder="123 456" pattern="\d{5}" required />
                            </div>
                        </div>

                    </div>

                    <div class="column">
                        <h3 class="title">Payment</h3>
                        <div class="input-box">
                            <span>Cards Accepted :</span>
                            <img src="imgcards.png" alt="cards" />
                        </div>
                        <div class="input-box">
                            <span>Name on Card :</span>
                            <input type="text" id="cardName" placeholder="Full Name" required />
                        </div>
                        <div class="input-box">
                            <span>Credit Card Number :</span>
                            <input type="text" id="cardNumber" placeholder="1234 1234 1234 1234" pattern="\d{16}"
                                required />
                        </div>
                        <div class="input-box">
                            <span>Expiry date :</span>
                            <input type="text" id="expDate" placeholder="01/24" required />
                        </div>

                        <div class="flex">
                            <div class="input-box">
                                <span>CVV :</span>
                                <input type="text" id="cvv" placeholder="123" pattern="\d{3}" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div id="errorMessages" class="error"></div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("paymentForm").addEventListener("submit", function (event) {
            var errorMessages = document.getElementById("errorMessages");
            errorMessages.innerHTML = ""; // Clear previous errors

            var cardNumber = document.getElementById("cardNumber").value;
            var cvv = document.getElementById("cvv").value;

            if (cardNumber.length !== 16 || isNaN(cardNumber)) {
                event.preventDefault();
                errorMessages.innerHTML += "<p>Please enter a valid 16-digit credit card number.</p>";
            }

            if (cvv.length !== 3 || isNaN(cvv)) {
                event.preventDefault();
                errorMessages.innerHTML += "<p>Please enter a valid 3-digit CVV.</p>";
            }
        });
    </script>
</body>

</html>