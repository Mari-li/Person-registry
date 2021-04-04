<?php
?>

<body>
<h3><?= $person->getName() . ' ' . $person->getSurname() . ' profile' ?></h3>
<form action="/search/personInfo/updateInfo" method="post">
    <div class="container">
        <p><b>Name</b></p>
        <input type="text" value="<?= $person->getName() ?>" id="name" disabled>
        <br>
        <p><b>Surname</b></p>
        <input type="text" value="<?= $person->getSurname() ?>" name="surname" id="surname" disabled>
        <br>
        <p><b>Personal code</b></p>
        <input type="text" value="<?= $person->getPersonalCode() ?>" name="personal_code" id="personalCode" disabled>
        <br>
        <p><b>Description</b>
        <p>
            <input type="text" value="<?= $person->getDescription() ?>" name="description" id="description">
            <br><br>
            <button type="submit" name="update" value="<?= $person->getPersonalCode() ?> ">Save</button>
    </div>
</form>
</body>

