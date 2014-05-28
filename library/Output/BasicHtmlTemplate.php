<?php use Rawebone\Jasmini\TestStatus; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test Results</title>

        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">

            <div class="row">
                <h1 class="text-muted">Test Results</h1>

                <?php foreach ($recorded as $description => $results) { ?>

                    <div class="col-lg-6">
                        <table class="table">

                            <thead>
                                <th><?= $description ?></th>
                                <th></th>
                            </thead>

                            <tbody>
                            <?php foreach ($results as $result) { ?>

                                <?php
                                    $icon = "";
                                    $colour = "";

                                    switch($result["status"]) {
                                        case TestStatus::PENDING:
                                            $icon = "time";
                                            $colour = "muted";
                                            break;
                                        case TestStatus::PASSED:
                                            $icon = "ok";
                                            $colour = "success";
                                            break;
                                        case TestStatus::FAILED:
                                            $icon = "remove";
                                            $colour = "danger";
                                            break;
                                    }
                                ?>

                                <tr>
                                    <td>
                                        <?= $result["title"] ?>
                                        <?= $result["exception"] ? "<br />Exception: " . $result["exception"] : "" ?>
                                    </td>
                                    <td>
                                        <span class="text-<?= $colour ?> glyphicon glyphicon-<?= $icon ?>"></span>
                                    </td>
                                </tr>

                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>

        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </body>
</html>


