<div>
    <p>NOTE: consider to use alphineJS next time.</p>
    <form id="myForm" wire:submit.prevent="get" wire:ignore>
        <label for="methodSelect">Select Method :</label>
        <select id="methodSelect">
            <option value="POST">Store</option>
            <option value="GET" selected>Get</option>
            <option value="POST">Update</option>
            <option value="POST">Delete</option>
        </select><br><br>
        <label for="fname">Name :</label><br>
        <input wire:model="name" type="text" id="name" name="name"><br><br>
        <label for="lname">Email (identifier for update or delete, unique) :</label><br>
        <input wire:model="email" type="text" id="email" name="email" required><br><br>
        <label for="lname">Phone :</label><br>
        <input wire:model="phone" type="text" id="phone" name="phone"><br><br>
        <label for="lname">Education :</label><br>
        <input wire:model="education" type="text" id="education" name="education"><br><br>
        <label for="lname">Birthday :</label><br>
        <input wire:model="birthday" type="date" id="birthday" name="birthday"><br><br>
        <label for="lname">Experience :</label><br>
        <input wire:model="experience" type="text" id="experience" name="experience"><br><br>
        <label for="lname">Last Position :</label><br>
        <input wire:model="last_position" type="text" id="last_position" name="last_position"><br><br>
        <label for="lname">Applied Position :</label><br>
        <input wire:model="applied_position" type="text" id="applied_position" name="applied_position"><br><br>
        <label for="lname">Skill :</label><br>
        <input wire:model="skill" type="text" id="skill" name="skill"><br><br>
        <label for="lname">Resume Link :</label><br>
        <input wire:model="resume_link" type="file" id="resume_link" name="resume_link"><br><br>
        <input type="submit" value="Submit">
    </form>

    <br><br>
    <form id="myForm" action={{url('/logout')}} method="GET">
        <input type="submit" value="Logout">
    </form>

    <br><br>
    <hr>
    <div wire:loading>
        Processing Data...
    </div>
    @php
        echo "<pre>".json_encode($datas, JSON_PRETTY_PRINT)."<pre>"
    @endphp

    {{-- just some basic js --}}
    <script>
        const form = document.getElementById('myForm');
        const methodSelect = document.getElementById('methodSelect');
        const emailInput = document.getElementById('email');
        const inputsToDisable = Array.from(form.querySelectorAll('input:not([name="email"])'));

        //set default
        emailInput.disabled = true;

        methodSelect.addEventListener('change', function() {
            const selectedMethodVal = methodSelect.value;
            const selectedOption = methodSelect.options[methodSelect.selectedIndex];
            const selectedMethod = selectedOption.textContent;

            // form.method = selectedMethodVal;

            if (selectedMethodVal !== 'GET') {
                emailInput.required = true;
                emailInput.disabled = false;
            } else {
                emailInput.required = false;
                emailInput.disabled = true;
            }

            if (selectedMethod === 'Update') {
                form.setAttribute('wire:submit.prevent', 'update');
            }
            else if (selectedMethod === 'Delete') {
                form.setAttribute('wire:submit.prevent', 'delete');
            }
            else if (selectedMethod === 'Store') {
                form.setAttribute('wire:submit.prevent', 'store');
            }
            else {
                form.setAttribute('wire:submit.prevent', 'get');
            }

        });
    </script>
</div>
