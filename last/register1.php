<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="registr.css">
    <script>
        function validateNameInput(inputId) {
            var nameInput = document.getElementById(inputId);
            var nameValue = nameInput.value;
            var validCharacters = /^[a-zA-Zа-яА-ЯёЁ]+$/;
            var errorSpan = document.getElementById(inputId + "-error");

            if (!validCharacters.test(nameValue)) {
                errorSpan.innerHTML = "Имя и фамилия должны содержать только буквы.";
                nameInput.setCustomValidity("Имя и фамилия должны содержать только буквы.");
            } else {
                errorSpan.innerHTML = "";
                nameInput.setCustomValidity("");
            }
        }

        function validateLastNameInput(inputId) {
            var lastNameInput = document.getElementById(inputId);
            var lastNameValue = lastNameInput.value;
            var validCharacters = /^[a-zA-Zа-яА-ЯёЁ]+$/;
            var errorSpan = document.getElementById(inputId + "-error");

            if (!validCharacters.test(lastNameValue)) {
                errorSpan.innerHTML = "Фамилия должна содержать только буквы.";
                lastNameInput.setCustomValidity("Фамилия должна содержать только буквы.");
            } else {
                errorSpan.innerHTML = "";
                lastNameInput.setCustomValidity("");
            }
        }

        function validateEmailInput(inputId) {
            var emailInput = document.getElementById(inputId);
            var emailValue = emailInput.value;
            var validEmail = /\S+@\S+\.\S+/;
            var errorSpan = document.getElementById(inputId + "-error");

            if (!validEmail.test(emailValue)) {
                errorSpan.innerHTML = "Введите корректный email адрес.";
                emailInput.setCustomValidity("Введите корректный email адрес.");
            } else {
                errorSpan.innerHTML = "";
                emailInput.setCustomValidity("");
            }
        }

        function validatePhoneNumberInput(inputId) {
    var phoneNumberInput = document.getElementById(inputId);
    var phoneNumberValue = phoneNumberInput.value;
    var validPhoneNumber = /^\d{3}-\d{3}-\d{4}$/; // Регулярное выражение для номера телефона в формате XXX-XXX-XXXX
    var errorSpan = document.getElementById(inputId + "-error");

    if (!validPhoneNumber.test(phoneNumberValue)) {
        errorSpan.innerHTML = "Номер телефона должен быть в формате XXX-XXX-XXXX.";
        phoneNumberInput.setCustomValidity("Номер телефона должен быть в формате XXX-XXX-XXXX.");
    } else {
        errorSpan.innerHTML = "";
        phoneNumberInput.setCustomValidity("");
    }
}

        function validatePasswordInput(inputId) {
            var passwordInput = document.getElementById(inputId);
            var passwordValue = passwordInput.value;
            var errorSpan = document.getElementById(inputId + "-error");

            if (passwordValue.length < 3) {
                errorSpan.innerHTML = "Пароль должен содержать не менее 3 символов.";
                passwordInput.setCustomValidity("Пароль должен содержать не менее 3 символов.");
            } else {
                errorSpan.innerHTML = "";
                passwordInput.setCustomValidity("");
            }
        }

        function validateForm() {
            var firstNameInput = document.getElementById("first-name");
            var lastNameInput = document.getElementById("last-name");
            var emailInput = document.getElementById("email");
            var phoneNumberInput = document.getElementById("phone-number");
            var passwordInput = document.getElementById("password");
            var firstNameValue = firstNameInput.value;
            var lastNameValue = lastNameInput.value;
            var emailValue = emailInput.value;
            var phoneNumberValue = phoneNumberInput.value;
            var passwordValue = passwordInput.value;
            var validCharacters = /^[a-zA-Zа-яА-ЯёЁ]+$/;
            var validEmail = /\S+@\S+\.\S+/;
            var validPhoneNumber = /^\d{10}$/;
            var firstNameErrorSpan = document.getElementById("first-name-error");
            var lastNameErrorSpan = document.getElementById("last-name-error");
            var emailErrorSpan = document.getElementById("email-error");
            var phoneNumberErrorSpan = document.getElementById("phone-number-error");
            var passwordErrorSpan = document.getElementById("password-error");

            if (!validCharacters.test(firstNameValue)) {
                firstNameErrorSpan.innerHTML = "Имя должно содержать только буквы.";
                firstNameInput.setCustomValidity("Имя должно содержать только буквы.");
            } else {
                firstNameErrorSpan.innerHTML = "";
                firstNameInput.setCustomValidity("");
            }

            if (!validCharacters.test(lastNameValue)) {
                lastNameErrorSpan.innerHTML = "Фамилия должна содержать только буквы.";
                lastNameInput.setCustomValidity("Фамилия должна содержать только буквы.");
            } else {
                lastNameErrorSpan.innerHTML = "";
                lastNameInput.setCustomValidity("");
            }

            if (!validEmail.test(emailValue)) {
                emailErrorSpan.innerHTML = "Введите корректный email адрес.";
                emailInput.setCustomValidity("Введите корректный email адрес.");
            } else {
                emailErrorSpan.innerHTML = "";
                emailInput.setCustomValidity("");
            }

            if (!validPhoneNumber.test(phoneNumberValue)) {
                phoneNumberErrorSpan.innerHTML = "Номер телефона должен быть в формате XXX-XXX-XXXX.";
                phoneNumberInput.setCustomValidity("Номер телефона должен быть в формате XXX-XXX-XXXX.");
            } else {
                phoneNumberErrorSpan.innerHTML = "";
                phoneNumberInput.setCustomValidity("");
            }

            if (passwordValue.length < 3) {
                passwordErrorSpan.innerHTML = "Пароль должен содержать не менее 3 символов.";
                passwordInput.setCustomValidity("Пароль должен содержать не менее 3 символов.");
            } else {
                passwordErrorSpan.innerHTML = "";
                passwordInput.setCustomValidity("");
            }

            return true; // Возвращаем true, так как мы проверяем все поля формы
        }

        function validateForm() {
        var robotCheckbox = document.getElementById("robot-check");

        if (!robotCheckbox.checked) {
            alert("Подтвердите, что вы не робот.");
            return false;
        }

        return true;
    }
    </script>
</head>
<body>
    <div class="container">
        <div class="registration-box">
            <h2>Регистрация</h2>
            <form action="registration_handler1.php" method="post" onsubmit="return validateForm()">
                <div class="input-group">
                    <label for="first-name">Имя:</label>
                    <input type="text" id="first-name" name="FirstName" required oninput="validateNameInput('first-name')">
                    <span id="first-name-error" class="error-message"></span>
                </div>
                <div class="input-group">
                    <label for="last-name">Фамилия:</label>
                    <input type="text" id="last-name" name="LastName" required oninput="validateLastNameInput('last-name')">
                    <span id="last-name-error" class="error-message"></span>
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="Email" required oninput="validateEmailInput('email')">
                    <span id="email-error" class="error-message"></span>
                </div>
                <div class="input-group">
                    <label for="phone-number">Номер телефона:</label>
                    <input type="tel" id="phone-number" name="PhoneNumber" required oninput="validatePhoneNumberInput('phone-number')">
                    <span id="phone-number-error" class="error-message"></span>
                </div>
                <div class="input-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="Password" required oninput="validatePasswordInput('password')">
                    <span id="password-error" class="error-message"></span>
                </div>
                <div class="input-group">
                    <label for="robot-check">Я не робот:</label>
                    <input type="checkbox" id="robot-check" name="robotCheck" required>
                </div>
                <button type="submit" name="register">Зарегистрироваться</button>
                <a href="main1.php" class="return-button">Вернуться на главную</a>
            </form>
        </div>
    </div>
</body>
</html>
