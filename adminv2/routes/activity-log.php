<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Activity Logs</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Recent Activity</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Activity Logs</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- TABLE AREA -->
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Activity Logs</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Log ID</th>
                        <th>Action</th>
                        <th>Table Affected</th>
                        <th>Log Message</th>
                        <th>Admin ID</th>
                        <th>Dean ID</th>
                        <th>Program Head ID</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody id="activity-log-container">
                </tbody>
            </table>
            <div class="pagination">
            </div>
        </div>
    </div>

</main>
<!-- MAIN -->

<!-- sweet alert  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JS AND JQUERY FOR PAGINATION -->
<script src="js/activity-logs.js"></script>