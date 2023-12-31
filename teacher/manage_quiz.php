<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

$quizDetails = null;

if (isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];

    if (is_numeric($quiz_id)) {
        $stmt = $conn->prepare("SELECT * FROM tbl_quiz WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $quizDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}

$errors = array();
$message = array();

if (isset($_POST['submit_update'])) {
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $quiz_type = filter_var($_POST['quiz_type'], FILTER_SANITIZE_STRING);
    $retryAfter = filter_var($_POST['retryAfter'], FILTER_VALIDATE_INT);
    $numberOfItems = filter_var($_POST['numberOfItems'], FILTER_VALIDATE_INT);
    $passingScore = filter_var($_POST['passingScore'], FILTER_VALIDATE_INT);

    if (empty($status)) {
        $errors['status'] = "Quiz status is required";
    }

    if (empty($title)) {
        $errors['title'] = "Quiz title is required";
    }

    if (empty($description)) {
        $errors['description'] = "Quiz description is required";
    }

    if (empty($quiz_type)) {
        $errors['quiz_type'] = "Quiz category is required";
    }

    if ($retryAfter === false || $retryAfter < 0) {
        $errors['retryAfter'] = "Invalid Retry After value";
    }

    if ($numberOfItems === false || $numberOfItems <= 0) {
        $errors['numberOfItems'] = "Invalid Number of Items value";
    }

    if ($passingScore === false || $passingScore < 0) {
        $errors['passingScore'] = "Invalid Passing Score value";
    }

    if (empty($errors)) {
        $retryAfterSeconds = $_POST['retryAfter'];

        $updateStmt = $conn->prepare("UPDATE tbl_quiz SET status = :status, quiz_title = :title, quiz_description = :description, quiz_type = :quiz_type, numberOfItems = :numberOfItems, passingScore = :passingScore, retryAfter = :retryAfter, last_updated = NOW() WHERE quiz_id = :quiz_id");
        $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
        $updateStmt->bindParam(':title', $title, PDO::PARAM_STR);
        $updateStmt->bindParam(':description', $description, PDO::PARAM_STR);
        $updateStmt->bindParam(':quiz_type', $quiz_type, PDO::PARAM_STR);
        $updateStmt->bindParam(':numberOfItems', $numberOfItems, PDO::PARAM_INT);
        $updateStmt->bindParam(':passingScore', $passingScore, PDO::PARAM_INT);
        $updateStmt->bindParam(':retryAfter', $retryAfterSeconds, PDO::PARAM_INT);
        $updateStmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            $_SESSION['message'] = "Quiz updated successfully";
            header("Location: manage_quiz.php?quiz_id={$quiz_id}");
            exit();
        } else {
            $errors['update'] = "Failed to update quiz";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzes</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>

    <section class="playlists playlist-form">
        <h1 class="heading">Manage Quizzes</h1>
        <div class="box-container" style="grid-template-columns: repeat(auto-fit, 55rem);">
            <?php if ($quizDetails): ?>
                <div class="box" id="boxbox" style="text-align: center;">
                    <form action="" method="post">
                        <h3 class="title" style="margin-bottom: .5rem; font-size: 25px;">Update Quiz</h3>

                        <p>Quiz status <span>*</span></p>
                        <select name="status" class="box" required>
                            <option value="" selected disabled>-- Select Status --</option>
                            <option value="active" <?php echo ($quizDetails['status'] == 'active') ? 'selected' : ''; ?>>
                                active</option>
                            <option value="deactive" <?php echo ($quizDetails['status'] == 'deactive') ? 'selected' : ''; ?>>
                                deactive</option>
                        </select>

                        <p>Quiz title <span>*</span></p>
                        <input type="text" name="title" maxlength="100" required placeholder="enter Quiz title" class="box"
                            value="<?php echo $quizDetails['quiz_title']; ?>">
                        <?php if (!empty($errors['title'])): ?>
                            <span style="color: red;">
                                <?php echo $errors['title']; ?>
                            </span>
                        <?php endif; ?>

                        <p>Quiz description <span>*</span></p>
                        <textarea name="description" class="box" required placeholder="write description" maxlength="1000"
                            cols="30" rows="10"><?php echo $quizDetails['quiz_description']; ?></textarea>

                        <?php if (!empty($errors['description'])): ?>
                            <span style="color: red;">
                                <?php echo $errors['description']; ?>
                            </span>
                        <?php endif; ?>

                        <p>Category <span>*</span></p>
                        <select name="quiz_type" class="box" required>
                            <option value="" selected disabled>-- Select Category --</option>

                            <?php
                            $availableCategories = array("pre-test", "post-test");

                            foreach ($availableCategories as $categoryOption) {
                                $selected = ($quizDetails['quiz_type'] == $categoryOption) ? 'selected' : '';
                                echo "<option value='{$categoryOption}' $selected>{$categoryOption}</option>";
                            }
                            ?>
                        </select>

                        <?php if (!empty($errors['quiz_type'])): ?>
                            <span style="color: red;">
                                <?php echo $errors['quiz_type']; ?>
                            </span>
                        <?php endif; ?>

                        <p>Number of Items <span>*</span></p>
                        <input type="text" name="numberOfItems" id="numberOfItems" required class="box"
                            value="<?php echo $quizDetails['numberOfItems']; ?>">

                        <?php if (!empty($errors['numberOfItems'])): ?>
                            <span style="color: red;">
                                <?php echo $errors['numberOfItems']; ?>
                            </span>
                        <?php endif; ?>

                        <p>Passing Score <span>*</span></p>
                        <input type="text" name="passingScore" id="passingScore" required class="box"
                            value="<?php echo $quizDetails['passingScore']; ?>">

                        <?php if (!empty($errors['passingScore'])): ?>
                            <span style="color: red;">
                                <?php echo $errors['passingScore']; ?>
                            </span>
                        <?php endif; ?>

                        <p>Quiz Retry Interval <span>*</span></p>
                        <input type="text" name="retryAfterDisplay" id="retryAfterDisplay" required
                            placeholder="enter Retry After (in hour format)" class="box"
                            value="<?php echo gmdate('H', $quizDetails['retryAfter']); ?>">
                        <input type="hidden" name="retryAfter" value="<?php echo $quizDetails['retryAfter']; ?>">

                        <?php if (!empty($errors['retryAfter'])): ?>
                            <span style="color: red;">
                                <?php echo $errors['retryAfter']; ?>
                            </span>
                        <?php endif; ?>

                        <input type="submit" value="Update Quiz" name="submit_update" class="btn">
                    </form>
                </div>

                <div class="box" id="boxbox" style="text-align: center;">

                    <form action="post">
                        <h3 class="title" style="margin-bottom: .5rem; font-size: 25px;">Quiz Questions</h3>
                        <style>
                            .table-container {
                                width: 100%;
                                max-height: 500px;
                                overflow-x: auto;
                                overflow-y: auto;
                            }

                            .title {
                                font-size: 20px;
                                justify-content: center;
                            }

                            .question-container {
                                display: flex;
                                align-items: flex-start;
                            }

                            .question {
                                font-size: 30px;
                                margin-left: 0;
                                word-wrap: break-word;
                            }

                            .options-list {
                                list-style: none;
                                padding-left: 0;
                                display: flex;
                                flex-direction: column;
                                justify-content: space-around;
                                align-items: flex-start;
                            }

                            .actions {
                                text-align: right;
                                display: flex;
                                flex-direction: column;
                                align-items: flex-end;
                                height: 100%;
                            }

                            .action-header {
                                text-align: right;
                                width: 50%;
                            }

                            .actions button {
                                margin-top: 5px;
                                padding: 8px 12px;
                                width: 80px;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                                font-size: 16px;
                                transition: background-color 0.3s;
                            }

                            .actions button.edit {
                                background-color: #FFD700;
                                color: #000;
                            }

                            .actions button.edit:hover {
                                background-color: #FFC107;
                            }

                            .actions button.delete {
                                background-color: #FF0000;
                                color: #fff;
                            }

                            .actions button.delete:hover {
                                background-color: #DC143C;
                            }

                            tbody tr:nth-child(even) {
                                background-color: #333;
                            }
                        </style>

                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr style="font-size: 20px; align-items:center;" class="title">
                                        <th>Question List:</th>
                                        <th class="action-header">Actions:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $selQuest = $conn->prepare("SELECT * FROM tbl_quizquestions WHERE quiz_id = ? ORDER BY question_id ASC");
                                    $selQuest->execute([$quiz_id]);

                                    $counter = 1;

                                    while ($row = $selQuest->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td class="title">
                                                <div class="question-container">
                                                    <p class="question" style="font-size: 30px;">
                                                        <?= $counter++; ?>.
                                                        <?php
                                                        $quizQuestion = $row['quiz_question'];
                                                        $brokenText = wordwrap($quizQuestion, 30, "<br />\n", true);
                                                        echo $brokenText;
                                                        ?>
                                                    </p>
                                                </div>
                                                <ul class="options-list">
                                                    <?php
                                                    for ($optionNumber = 1; $optionNumber <= 4; $optionNumber++) {
                                                        $optionValue = $row['option_' . $optionNumber];
                                                        $isCorrect = ($optionValue == $row['correct_answer']);

                                                        $style = ($isCorrect) ? 'color: green; font-weight: bold;' : '';
                                                        echo '<li class="option" style="' . $style . '">-' . $row['option_' . $optionNumber] . '</li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </td>
                                            <td class="actions">
                                                <button class="edit">Edit</button>
                                                <button class="delete">Delete</button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <input type="button" value="Add Question" class="btn" onclick="openModal()">
                    </form>
                </div>


                <!-- MODAL AREA -->
                <style>
                    .modal {
                        display: none;
                        position: fixed;
                        z-index: 1000;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        overflow: auto;
                        background-color: rgba(0, 0, 0, 0.7);
                    }

                    .modal-content {
                        margin: 0 auto;
                        width: 80%;
                        max-width: 500px;
                        box-sizing: border-box;
                    }

                    .close {
                        color: #aaa;
                        float: right;
                        font-size: 28px;
                        font-weight: bold;
                    }

                    .close:hover,
                    .close:focus {
                        color: black;
                        text-decoration: none;
                        cursor: pointer;
                    }

                    .side-bar,
                    .navbar {
                        z-index: 999;
                    }
                </style>

                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="box">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <div id="boxbox" style="text-align: center;">
                                <form method="post" id="questionForm" onsubmit="return submitQuestionForm();">
                                    <h3 class="title" style="margin-bottom: .5rem; font-size: 25px;">Add Questions</h3>
                                    <textarea name="question" id="question" class="box" required
                                        placeholder="Enter Question" cols="30" rows="10"
                                        oninput="updateSelectedOption()"></textarea>

                                    <input type="text" class="box" id="m1" placeholder="Enter Option A." name="opt1"
                                        required oninput="updateSelectedOption()">
                                    <div id="selectedOption1"></div>

                                    <input type="text" class="box" id="m2" placeholder="Enter Option B." name="opt2"
                                        required oninput="updateSelectedOption()">
                                    <div id="selectedOption2"></div>

                                    <input type="text" class="box" id="m3" placeholder="Enter Option C." name="opt3"
                                        required oninput="updateSelectedOption()">
                                    <div id="selectedOption3"></div>

                                    <input type="text" class="box" id="m4" placeholder="Enter Option D." name="opt4"
                                        required oninput="updateSelectedOption()">
                                    <div id="selectedOption4"></div>

                                    <p>Select Correct Ans: <span>*</span></p>
                                    <select name="correct_option" id="correct_option" class="box">

                                    </select>


                                    <input type="hidden" name="submit_question" value="1">
                                    <input type="submit" value="Save Question" class="btn" name="submit_question">
                                    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script src="../scripts/script.js"></script>

    <script>
        document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
            if (content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
        });
    </script>

    <script>
        const input = document.getElementById('retryAfter');
        const numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        input.addEventListener('keyup', function (event) {
            if (numbers.indexOf(event.key) == -1) {
                input.value = input.value.replace(/[^0-9]/g, '');
            }
        });
    </script>

    <script>
        function updateSelectedOption() {
            option_1 = document.getElementById('m1').value;
            option_2 = document.getElementById('m2').value;
            option_3 = document.getElementById('m3').value;
            option_4 = document.getElementById('m4').value;

            document.getElementById('correct_option').innerHTML = `
                <option value="${option_1}">${option_1}</option>
                <option value="${option_2}">${option_2}</option>
                <option value="${option_3}">${option_3}</option>
                <option value="${option_4}">${option_4}</option>
            `;

            return true;
        }

        function openModal() {
            var modal = document.getElementById('myModal');
            var modalContent = document.querySelector('.modal-content');
            modal.style.display = 'block';
            modalContent.style.marginTop = '10%';
        }
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }
        function validateQuestionForm() {
            var question = document.getElementById('question').value.trim();
            if (question === '') {
                alert('Please enter a question.');
                return false;
            }

            var options = ['m1', 'm2', 'm3', 'm4'];
            for (var i = 0; i < options.length; i++) {
                var option = document.getElementById(options[i]).value.trim();
                if (option === '') {
                    alert('Please enter all options.');
                    return false;
                }
            }

            var correctAnswer = document.getElementById('correct_option').value;
            if (!correctAnswer) {
                alert('Please select the correct answer.');
                return false;
            }

            return true;
        }


        function submitQuestionForm() {
            var formData = new FormData(document.getElementById('questionForm'));
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'question_handler.php', true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log("Response received");
                    var response = JSON.parse(xhr.responseText);

                    if (response.success == true) {
                        console.log(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Question added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        document.getElementById('question').value = "";
                        document.getElementById('m1').value = "";
                        document.getElementById('m2').value = "";
                        document.getElementById('m3').value = "";
                        document.getElementById('m4').value = "";
                        document.getElementById('correct_option').value = "";
                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                }
            };

            xhr.send(formData);

            return false;
        }


    </script>



    <script>

        <?php if (isset($_SESSION['message'])): ?>
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "<?php echo $_SESSION['message']; ?>",
                showConfirmButton: false,
                timer: 1500
            });
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    </script>

</body>

</html>