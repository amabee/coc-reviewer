<link rel="stylesheet" type="text/css" href="styles/mycss.css">
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>MANAGE STUDENTS</div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header" style="justify-content: space-between;">
                    Student List
                    <div class="pull-right">
                        <button class="btn btn-lg btn-success" data-toggle="modal"
                            data-target="#yawa">Add Students</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selExmne = $conn->query("SELECT * FROM tbl_students ORDER BY id DESC ");
                        if ($selExmne->rowCount() > 0) {
                            while ($selStudRow = $selExmne->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td>
                                        <?php echo $selStudRow['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $selStudRow['firstname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $selStudRow['lastname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $selStudRow['gender']; ?>
                                    </td>
                                    <td>
                                        <?php echo $selStudRow['email']; ?>
                                    </td>
                                    <td>
                                        <a rel="facebox"
                                            href="facebox_modal/updateExaminee.php?id=<?php echo $selStudRow['id']; ?>"
                                            class="btn btn-sm btn-primary">Update</a>

                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="2">
                                    <h3 class="p-3">No Sections Found</h3>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

