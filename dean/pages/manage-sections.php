<link rel="stylesheet" type="text/css" href="/3Mcss/mycss.css">
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>MANAGE SECTIONS</div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Sections List
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                        <thead>
                            <tr>
                                <th class="text-left pl-4">Course Name</th>
                                <th class="text-center" width="20%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $selCourse = $conn->query("SELECT * FROM tbl_section ORDER BY section_id DESC ");
                            if ($selCourse->rowCount() > 0) {
                                while ($selCourseRow = $selCourse->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td class="pl-4">
                                            <?php echo $selCourseRow['section_id']; ?>
                                        </td>
                                        <td class="text-center">
                                            <a rel="facebox" style="text-decoration: none;" class="btn btn-primary btn-sm"
                                                href="facebox_modal/updateSection.php?id=<?php echo $selCourseRow['section_id']; ?>"
                                                id="updateSection">Update</a>
                                           
                                           
                                           
                                        </td>
                                    </tr>

                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="2">
                                        <h3 class="p-3">No sections Found</h3>
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