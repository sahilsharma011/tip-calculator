<?php
if (isset($_POST['submitted'])) {
    $errors = array();
    if ((!isset($_POST['bill']) || $_POST['bill'] == null)) {
        array_push($errors, 'Bill is required');
    } elseif (!is_numeric($_POST['bill'])) {
        array_push($errors, 'Bill should be a number');
    } elseif ($_POST['bill'] < 1) {
        array_push($errors, 'Bill should be greater than 0');
    }
    if (!isset($_POST['tip'])) {
        array_push($errors, 'Tip is required');
    } else {
        if ($_POST['tip'] == 'custom') {
            if (!isset($_POST['custom_tip']) || $_POST['custom_tip'] == null) {
                array_push($errors, 'Custom Tip is required');
            } elseif (!is_numeric($_POST['custom_tip'])) {
                array_push($errors, 'Tip should be a number');
            } elseif ($_POST['custom_tip'] < 1) {
                array_push($errors, 'Tip should be greater than 0');
            } elseif ($_POST['custom_tip'] > 100) {
                array_push($errors, 'Tip should be lesser than 100');
            }
        }
    }
    if (empty($errors)) {
        $bill = (float)$_POST['bill'];
        $tip_percent = !isset($_POST['custom_tip']) ? (float)$_POST['tip'] : (float)$_POST['custom_tip'];
        $tip = $bill * $tip_percent / 100;
        $total = $bill + $tip;
        $result = $total;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tip Calculator</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.light_blue-blue.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<div class="demo-layout mdl-layout mdl-layout--fixed-header mdl-js-layout mdl-color--grey-100">
    <header class="demo-header mdl-layout__header mdl-layout__header--scroll mdl-color--grey-100 mdl-color-text--grey-800">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Web Security Prework</span>
            <div class="mdl-layout-spacer"></div>
        </div>
    </header>
    <div class="demo-ribbon"></div>
    <main class="demo-main mdl-layout__content">
        <div class="demo-container mdl-grid">
            <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
            <div class="demo-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--8-col">
                <h3>Tip Calculator</h3>
                <form action="/index.php" method="post">
                    <input type="hidden" value='true' name="submitted">
                    <?php
                    $bill = '';
                    if (isset($_POST['bill'])) {
                        $bill = $_POST['bill'];
                    }
                    ?>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="bill" name="bill" required
                               value="<?php echo $bill ?>">
                        <label class="mdl-textfield__label" for="bill">Bill Subtotal (in dollars)</label>
                    </div>
                    <div>
                        <span>Tip Percentage : </span>
                        <?php
                        if (isset($_POST['tip'])) {
                            if ('custom' == $_POST['tip']) {
                                $custom_checked = 'checked';
                            }
                        }
                        for ($i = 10; $i <= 20; $i += 5) {
                            $required = '';
                            $checked = '';
                            if ($i == 10) {
                                $required = 'required';
                            }
                            if (isset($_POST['tip'])) {
                                if ($i == $_POST['tip']) {
                                    $checked = 'checked';
                                }
                            }
                            echo "<label class=\"mdl-radio mdl-js-radio mdl-js-ripple-effect\" for=\"$i\">
                            <input type=\"radio\" id=\"$i\" class=\"mdl-radio__button\" onclick=\"radioChange(event)\"  name=\"tip\" value=\"$i\" $required $checked/>
                            <span class=\"mdl-radio__label\">$i%</span>
                        </label> &nbsp;";
                        }
                        ?>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="custom">
                            <input type="radio" id="custom" class="mdl-radio__button" onclick="radioChange(event)"
                                   name="tip" value="custom" <?php if (isset($custom_checked)) echo $custom_checked ?>/>
                            <span class="mdl-radio__label">Custom</span>
                        </label>
                        <?php
                        $custom_tip = '';
                        if (isset($_POST['custom_tip'])) {
                            $custom_tip = $_POST['custom_tip'];
                        }
                        ?>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="custom_tip" name="custom_tip"
                                   value="<?php echo $custom_tip?>">
                            <label class="mdl-textfield__label" for="custom_tip">Custom Tip %</label>
                        </div>
                    </div>
                    <br>
                    <input type="submit"
                           class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
                           value="Submit">
                </form>

                <br>
                <?php
                if (isset($result) && isset($tip)) {
                    echo '<div style="background-color: rgba(0, 0, 0, 0.10);padding: 1%">'
                        . 'Total Cost is $ ' . $result
                        . '<br>'
                        . 'Total Tip is $ ' . $tip
                        . '</div>';
                }
                ?>
                <br>
                <?php
                if (isset($errors) && !empty($errors)) {
                    echo '<div style="background-color: rgba(255, 0, 0, 0.10);padding: 1%">';
                    foreach ($errors as $error) {
                        echo $error . '<br>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <footer class="demo-footer mdl-mini-footer" style="position: absolute;right: 0;bottom: 0;left: 0;">
            <div class="mdl-mini-footer--left-section">
                <ul class="mdl-mini-footer--link-list">

                </ul>
            </div>
        </footer>
    </main>
</div>
</body>
<script>
    document.getElementById('custom_tip').disabled = true;
    if (document.querySelector('input[name = "tip"]:checked')) {
        if (document.querySelector('input[name = "tip"]:checked').value == 'custom') {
            document.getElementById('custom_tip').disabled = false;
            document.getElementById('custom_tip').required = true;
            document.getElementById('custom_tip').focus();
        }
    }
    function radioChange(event) {
        if (event.target.id === 'custom') {
            document.getElementById('custom_tip').disabled = false;
            document.getElementById('custom_tip').required = true;
            document.getElementById('custom_tip').focus();
        }
        else {
            document.getElementById('custom_tip').disabled = true;
        }
    }
</script>
</html>
