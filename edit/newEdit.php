<?php 
    include('G:\Program\Soft\MAMP\htdocs\validation-form/checkAuth.php');
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1); 

$mysql = new mysqli('localhost','root','root','educationProgram-db');

		
$newEdits = $mysql->query("SELECT edits.edit_id, disp.disp_name, edits.knowledge, edits.skills, edits.attaiment
    FROM `edits` edits
    LEFT JOIN `discipline` disp ON disp.disp_id = edits.disp_id
    WHERE `checkEdits` = 0");

echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='css/style.css'>
    <div class='container mt-4'>
    <a href='/' class='btn btn-outline-primary' role='button' aria-pressed='true'>Назад</a>";
$rowCount = $newEdits ->num_rows;
if ($rowCount == 0) {
    echo " Предложений о правке больше не осталось.";
} else {
    while ($newEdit = mysqli_fetch_array($newEdits)) {
        echo "
                <p> Дисциплина «".$newEdit['disp_name']."»</p>
                <table class='table table-striped table-bordered table-hover table-sm'>
                <thead>
                    <tr class='table-primary'>
                        <th scope='col' width='30%'>Знания</th>
                        <th scope='col' width='30%'>Умения</th>
                        <th scope='col' width='30%'>Навыки</th>
                        <th scope='col' width='5%'>Принять</th>
                        <th scope='col' width='5%'>Отклонить</th>
                    </form>
                    </tr>
                </thead>
                <tbody> 
                    <tr>
                        <td>".$newEdit['knowledge']."</td>
                        <td>".$newEdit['skills']."</td>
                        <td>".$newEdit['attaiment']."</td>
                        <td>
                            <form action='updateEdit.php?id =' method='POST'>
                                <input type='hidden' name='edit_id' value='{$newEdit['edit_id']}' />
                                <button class='btn btn-success' type='submit'>Принять</button>
                            </form>
                        </td>
                        <td>
                            <form action='deleteEdit.php' method='POST'>
                                <input type='hidden' name='edit_id' value='{$newEdit['edit_id']}' />
                                <button class='btn btn-success' type='submit'>Отклонить</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                </table>";  
    }
    
}
echo "</div>";
$mysql-> close();
?>