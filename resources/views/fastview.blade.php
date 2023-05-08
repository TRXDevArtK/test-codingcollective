<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>fastview</title>
</head>
<body>
    <form id="myForm" action={{url('/candidate')}} method="POST" enctype="multipart/form-data">
        @csrf
        <label for="methodSelect">Select Method :</label>
        <select id="methodSelect">
            <option value="POST">Store</option>
            <option value="GET">Get</option>
            <option value="POST">Update</option>
            <option value="POST">Delete</option>
        </select><br><br>
        <label for="fname">Name :</label><br>
        <input type="text" id="name" name="name"><br><br>
        <label for="lname">Email (identifier for update or delete, unique) :</label><br>
        <input type="text" id="email" name="email" required><br><br>
        <label for="lname">Phone :</label><br>
        <input type="text" id="phone" name="phone"><br><br>
        <label for="lname">Education :</label><br>
        <input type="text" id="education" name="education"><br><br>
        <label for="lname">Birthday :</label><br>
        <input type="date" id="birthday" name="birthday"><br><br>
        <label for="lname">Experience :</label><br>
        <input type="text" id="experience" name="experience"><br><br>
        <label for="lname">Last Position :</label><br>
        <input type="text" id="last_position" name="last_position"><br><br>
        <label for="lname">Applied Position :</label><br>
        <input type="text" id="applied_position" name="applied_position"><br><br>
        <label for="lname">Skill :</label><br>
        <input type="text" id="skill" name="skill"><br><br>
        <label for="lname">Resume Link :</label><br>
        <input type="file" id="resume_link" name="resume_link"><br><br>
        <input type="submit" value="Submit">
    </form>

    <br><br>

    <form id="myForm" action={{url('/logout')}} method="GET">
        <input type="submit" value="Logout">
    </form>

    <script>
        const form = document.getElementById('myForm');
        const methodSelect = document.getElementById('methodSelect');
        const emailInput = document.getElementById('email');
        const inputsToDisable = Array.from(form.querySelectorAll('input:not([name="email"])'));

        methodSelect.addEventListener('change', function() {
            const selectedMethodVal = methodSelect.value;
            const selectedOption = methodSelect.options[methodSelect.selectedIndex];
            const selectedMethod = selectedOption.textContent;

            form.method = selectedMethodVal;

            if (selectedMethodVal !== 'GET') {
                emailInput.required = true;
            } else {
                emailInput.required = false;
            }

            if (selectedMethod === 'Update') {
                form.action = 'http://127.0.0.1:8000/candidate/update';
            } else if (selectedMethod === 'Delete') {
                form.action = 'http://127.0.0.1:8000/candidate/delete';
            } else {
                form.action = 'http://127.0.0.1:8000/candidate';
            }

        });
    </script>
</body>
</html>
