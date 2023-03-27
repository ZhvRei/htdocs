<?php 
    require("rights/right.php");
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);   

    include("validation-form/checkAuth.php");
    
    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    if(has_right("admin")) {
        $resultDiscipline = $mysql->query("SELECT * FROM `discipline` WHERE 1");

        $resultEducationProgram = $mysql->query("SELECT * FROM `competency-passport` WHERE 1");

        $resultEducator = $mysql->query("SELECT users.name, users.user_id FROM  `users-auth` users
            LEFT JOIN `role` role ON role.user_id = users.user_id
            WHERE role.rightOfAccess = 'educator';");

    } else {
        $resultEducationProgram = $mysql->query("SELECT * FROM `competency-passport` WHERE 1");

        $resultDiscipline = $mysql->query("SELECT * FROM `discipline` disp 
        LEFT JOIN `teaching-disciplines` teaching ON teaching.disp_id = disp.disp_id 
        WHERE teaching.user_id = ".$_COOKIE['user_id']);

        $resultSupervisor = $mysql->query("SELECT * FROM `discipline` WHERE 1");
    }

?>


<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Добавление данных</title> 
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a href="/" class="btn btn-outline-primary" role="button" aria-pressed="true">Назад</a>

    <?php if(has_right("admin")): ?>

        <div class="container mt-4">
            <div>
                <h3>Форма добавления образовательной программы</h3>
                <form action="additionInfo/addEducationProgram.php" method="post">
                    <input type="text" class="form-control" name="code" id="code" placeholder="Код образовательной программы"> <br />
                    <input type="text" class="form-control" name="educationProgramName" id="educationProgramName" placeholder="Название образовательной программы"> <br />
                    <button class="btn btn-success" type="submit">Добавить образовательную программу</button>
                </form>
            </div>
            <div>
                <h3>Форма добавления дисциплины</h3>
                <form action="additionInfo/addDiscipline.php" method="post">
                    <input type="text" class="form-control" name="disciplineName" id="disciplineName" placeholder="Название дисциплины"> <br />
                    <button class="btn btn-success" type="submit">Добавить дисциплину</button>
                </form>
            </div>
            <div>
                <h3>Форма добавления дисциплины в программу</h3>
                <form action="additionInfo/addDisciplineList.php" method="post">
                    <select name = "educationalProgram" class="form-select" aria-label="Default select example">
                        <option selected>Выберите образовательную программу</option>
                        <?php 
                            while($educationProgram = mysqli_fetch_array($resultEducationProgram)) {
                                echo "<option value='".$educationProgram['pass_id']. "'>".$educationProgram['name']."</option>";
                            }
                        ?>
                    </select>
                    <br />
                    <select name = "educator" class="form-select" aria-label="Default select example">
                        <option selected>Выберите преподавателя</option>
                        <?php 
                            while($Educator = mysqli_fetch_array($resultEducator)) {
                                echo "<option value='".$Educator['user_id']. "'>".$Educator['name']."</option>";
                            }
                        ?>
                    </select>
                    <br />
                    <select name = "disciplineList" class="form-select" aria-label="Default select example">
                        <option selected>Выберите дисциплину</option>
                        <?php 
                            while($Discipline = mysqli_fetch_array($resultDiscipline)) {
                                echo "<option value='".$Discipline['disp_id']."'>".$Discipline['disp_name']."</option>";
                            }
                        ?>
                    </select>
                    <br />
                        <button class="btn btn-success" type="submit">Закрепить дисциплину за программой</button>
                </form>
            </div>
            <div>
                <h3>Форма добавления индикаторов освоения</h3>
                <form action="additionInfo/addIndicator.php" method="post">
                    <select name = "disciplineIndicator" class="form-select" aria-label="Default select example">
                        <option selected>Выберите дисциплину</option>
                        <?php 
                            $resultDisciplines = $mysql->query("SELECT * FROM `discipline` WHERE 1");
                            while($Discipline = mysqli_fetch_array($resultDisciplines)) {
                                echo "<option value='".$Discipline['disp_id']."'>".$Discipline['disp_name']."</option>";
                            }
                        ?>
                    </select> <br />
                    <input type="text" class="form-control" name="knowledge" id="knowledge" placeholder="Освоенные знания"> <br />
                    <input type="text" class="form-control" name="skills" id="skills" placeholder="Освоенные умения"> <br />
                    <input type="text" class="form-control" name="attaiment" id="attaiment" placeholder="Освоенные навыки"> <br />
                    <button class="btn btn-success" type="submit">Добавить индикаторы усвоения</button>
                </form>
            </div>
        </div>
    <?php elseif(has_right("educator")): ?>
        <div class="container mt-4">
            <div>
                <h3>Форма добавления индикаторов освоения</h3>
                <form action="edit/addEdits.php" method="post">
                    <select name = "disciplineIndicator" class="form-select" aria-label="Default select example">
                        <option selected>Выберите дисциплину</option>
                        <?php 
                            $resultDisciplines = $mysql->query("SELECT DISTINCT disp.* FROM `discipline` disp
                                LEFT JOIN  `teaching-disciplines` teaching ON teaching.disp_id = disp.disp_id
                                WHERE teaching.user_id = ".$_COOKIE['user_id']);
                            while($Discipline = mysqli_fetch_array($resultDisciplines)) {
                                echo "<option value='".$Discipline['disp_id']."'>".$Discipline['disp_name']."</option>";
                            }
                        ?>
                    </select> <br />
                    <select name = "educationalProgram" class="form-select" aria-label="Default select example">
                        <option selected>Выберите образовательную программу</option>
                        <?php 
                            while($educationProgram = mysqli_fetch_array($resultEducationProgram)) {
                                echo "<option value='".$educationProgram['pass_id']. "'>".$educationProgram['name']."</option>";
                            }
                        ?>
                    </select> <br />
                    <input type="text" class="form-control" name="knowledge" id="knowledge" placeholder="Освоенные знания"> <br />
                    <input type="text" class="form-control" name="skills" id="skills" placeholder="Освоенные умения"> <br />
                    <input type="text" class="form-control" name="attaiment" id="attaiment" placeholder="Освоенные навыки"> <br />
                    <button class="btn btn-success" type="submit">Предложить правки руководителю</button>
                </form>
            </div>
        </div>
    <?php endif ?>
    </div>
</body>
</html>

<?php $mysql-> close(); ?>