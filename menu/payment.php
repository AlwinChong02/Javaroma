<!DOCTYPE html>
<html>

<head>
    <title>The Generics</title>
    <meta name="description" content="This is the description">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" />
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
            gap: 15px;
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
    </style>
</head>

<body>
    <div class="container">
        <div>
            <form method="post">
                <div class="row">
                    <div class="column">
                        <h3 class="title">Billing Address</h3>
                        <div class="input-box">
                            <span>Full name :</span>
                            <input type="text"
                                placeholder="Jacob Aiden" />
                        </div>
                        <div class="input-box">
                            <span>Email :</span>
                            <input type="text"
                                placeholder="example@gmail.com" />
                        </div>
                        <div class="input-box">
                            <span>Address :</span>
                            <input type="text"
                                placeholder="Room - Street - Locality" />
                        </div>
                        <div class="input-box">
                            <span>City :</span>
                            <input type="text"
                                placeholder="Kajang" />
                        </div>

                        <div class="flex">
                            <div class="input-box">
                                <span>State :</span>
                                <input type="text"
                                    placeholder="Selangor" />
                            </div>
                            <div class="input-box">
                                <span>Zip Code :</span>
                                <input type="text"
                                    placeholder="123 456" />
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
                            <input type="text"
                                placeholder="example@gmail.com" />
                        </div>
                        <div class="input-box">
                            <span>Credit Card Number :</span>
                            <input type="number"
                                placeholder="1234 1234 1234 1234" />
                        </div>
                        <div class="input-box">
                            <span>Exp. Month :</span>
                            <input type="text"
                                placeholder="August" />
                        </div>

                        <div class="flex">
                            <div class="input-box">
                                <span>Exp. Year :</span>
                                <input type="text"
                                    placeholder="2026" />
                            </div>
                            <div class="input-box">
                                <span>CVV :</span>
                                <input type="text"
                                    placeholder="123" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <button type="submit" onclick="window.location.href='payment_history.php'" class="btn">Submit</button>
        </div>
    </div>
</body>

</html>