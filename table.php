<?php 
    include('G:\Program\Soft\MAMP\htdocs\validation-form/checkAuth.php');
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    if (has_right("admin") or has_right("supervisor")) {
        $resultEducationProgram = $mysql->query
            ("SELECT pass.* FROM `competency-passport` pass
            LEFT JOIN `supervised-educational-programs` supervised ON pass.pass_id = supervised.pass_id
            LEFT JOIN `users-auth` users ON users.user_id = supervised.user_id
            WHERE 1"); 
    }

    if (has_right("educator")) {
        $resultEducationProgram = $mysql->query
            ("SELECT DISTINCT pass.* FROM `teaching-disciplines` teaching
            LEFT JOIN `disciplines_list` dispList ON dispList.disp_id = teaching.disp_id
            LEFT JOIN `competency-passport` pass ON pass.pass_id = dispList.pass_id
            WHERE teaching.user_id = ".$_COOKIE['user_id']);
    }

    if (has_right("supervisor")) {
		$resultEducationProgram = $mysql->query
            ("SELECT pass.* FROM `competency-passport` pass
            LEFT JOIN `supervised-educational-programs` supervised ON pass.pass_id = supervised.pass_id
            LEFT JOIN `users-auth` users ON users.user_id = supervised.user_id
            WHERE users.user_id = ".$_COOKIE['user_id']);

        $newEdits = $mysql->query("SELECT count(*) as count FROM `edits` WHERE `checkEdits` = 0");
        $newEditsCount = mysqli_fetch_array($newEdits);

        echo "<a href='edit/newEdit.php' class='btn btn-outline-primary' role='button' aria-pressed='true'>
        У вас [".$newEditsCount['count']."] новых предложений о правке</a> <br />";
    }

    while($educationProgram = mysqli_fetch_array($resultEducationProgram)) {
        
        if (has_right("educator")) {
            $resultDisciplines = $mysql->query 
            ("SELECT pass.code, pass.name, disp.disp_name, mastering.knowledge, mastering.skills, mastering.attaiment 
            FROM `competency-passport` pass 
            LEFT JOIN `disciplines_list` listD ON listD.pass_id = pass.pass_id 
            LEFT JOIN `discipline` disp ON listD.disp_id = disp.disp_id 
            LEFT JOIN `indicator-mastering` mastering ON mastering.disp_id = disp.disp_id 
            LEFT JOIN `teaching-disciplines` teaching ON teaching.disp_id = listD.disp_id
            WHERE listD.pass_id = ".$educationProgram['pass_id']." AND teaching.user_id = ".$_COOKIE['user_id']);
        } else {
            $resultDisciplines = $mysql->query 
            ("SELECT pass.code, pass.name, disp.disp_name, mastering.knowledge, mastering.skills, mastering.attaiment 
            FROM `competency-passport` pass 
            LEFT JOIN `disciplines_list` listD ON listD.pass_id = pass.pass_id 
            LEFT JOIN `discipline` disp ON listD.disp_id = disp.disp_id 
            LEFT JOIN `indicator-mastering` mastering ON mastering.disp_id = disp.disp_id 
            WHERE listD.pass_id = ".$educationProgram['pass_id']);
        }
        

        echo "<br /> <h5>Образовательная программа ".$educationProgram['code']." «".$educationProgram['name']."» </h5>";

        while($Discipline = mysqli_fetch_array($resultDisciplines)) {
            echo "
            <p> Дисциплина «".$Discipline['disp_name']."»</p>
            <table class='table table-striped table-bordered table-hover table-sm'>
            <thead>
                <tr class='table-primary'>
                    <th scope='col' width='33%'>Знания</th>
                    <th scope='col' width='33%'>Умения</th>
                    <th scope='col' width='33%'>Навыки</th>
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <td>".$Discipline['knowledge']."</td>
                    <td>".$Discipline['skills']."</td>
                    <td>".$Discipline['attaiment']."</td>
                </tr>
            </tbody>
            </table>";    
        }
    }
?>

<?php
    $mysql-> close();
?>