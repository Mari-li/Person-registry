<?php
?>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <h4>Person you looked for:</h4>
    <form method="get">
        <table>
            <thead style="display: table-header-group">
            <tr>
                <th>Number</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Personal code</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach ($foundedPersons->getAll() as $person) :?>
                <tr class="persons">
                    <td><?php echo ++$total; ?></td>
                    <td> <?php echo $person->getName(); ?></td>
                    <td> <?php echo $person->getSurname(); ?></td>
                    <td> <?php echo $person->getPersonalCode(); ?></td>
                    <td> <?php echo $person->getDescription(); ?></td>
                    <td>
                        <button formaction="/personInfo/update" type="submit" name="update"
                                value="<?= $person->getPersonalCode() ?>">Update
                        </button>
                    </td>
                    <td>
                        <button formaction="/personInfo/delete" type="submit" name="delete"
                                value="<?= $person->getPersonalCode() ?>">Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <br>
    </form>

<?php
