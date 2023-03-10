<?php
require_once 'sections/head.php';
require_once 'sections/header.php';
require_once "vendor/autoload.php";

if ($_SESSION['user']['login'] == false) {
    header("Location: /home");
    die;
}

$yurtici_info = $mysqli->query("SELECT * FROM yurtici_dataset WHERE userID = $userID")->fetch_assoc();

?>

<?php require_once 'userSections/sidebar.php'; ?>


<div class="dashboard-area">
    <div class="container-fluid py-5 mt-4 mt-lg-5 mb-lg-4 my-xl-5">
        <div class="row pt-sm-2 pt-lg-0">
            <!-- Page content-->
            <div class="col-lg-9 pt-4 pb-2 pb-sm-4">
                <h1 class="h2 mb-4">Yurtiçi Kargo API Bilgilerin</h1>
                <!-- Basic info-->
                <section class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mt-sm-n1 pb-4 mb-0 mb-lg-1 mb-xl-3">
                            <img width="38" class="me-2 pe-1" src="images/api_icons/yurtici.webp" alt="yurtici">
                            <h2 class="h4 mb-0">Key ve Parola</h2>
                        </div>


                        <?php
                        if ($_POST) {
                            // $keyNumber = strip_tags(addslashes($_POST['keyNumber']));
                            // $password = strip_tags(addslashes($_POST['password']));
                        } else {
                        ?>
                            <form action="" method="POST" role="form" id="yurticiApi">
                                <div class="row align-items-center g-3 g-sm-4 pb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label" for="new-pass">KEY</label>
                                        <div class="password-toggle">
                                            <input class="form-control" type="password" id="new-pass" name="keyNumber" value="<?php echo $yurtici_info['keyNumber'] ?>">
                                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="confirm-pass">PAROLA</label>
                                        <div class="password-toggle">
                                            <input class="form-control" type="password" id="confirm-pass" name="keyPassword" value="<?php echo $yurtici_info['keyPassword'] ?>">
                                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="konu" value="yurticiKey">
                                    <div class="d-flex justify-content-end pt-3">
                                        <button class="btn btn-secondary" type="button">Sil</button>
                                        <button class="btn btn-primary ms-3" type="submit">Kaydet</button>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>

                        <!-- <div class="alert alert-info d-flex mb-0" role="alert"><i class="ai-circle-info fs-xl"></i>
                            <div class="ps-2">Fill in the information 100% to receive more suitable offers.<a class="alert-link ms-1" href="account-settings.html">Go to settings!</a></div>
                        </div> -->
                    </div>
                </section>
            </div>

            <div class="col-lg-9 pt-4 pb-2 pb-sm-4">
                <h1 class="h2 mb-4">Kargo Sorgula</h1>
                <!-- Basic info-->
                <section class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mt-sm-n1 pb-4 mb-0 mb-lg-1 mb-xl-3">
                            <img width="38" class="me-2 pe-1" src="images/api_icons/yurtici.webp" alt="yurtici">
                            <h2 class="h4 mb-0">Key ve Parola</h2>
                        </div>


                        <?php

                        if ($_POST) {
                            $request = new YurticiKargo\Request();
                            $request->setUser($yurtici_info['keyNumber'], $yurtici_info['keyPassword'])->init("");

                            $key = $_POST['key'];
                            $queryShipment = $request->queryShipment($key);


                            print_r($queryShipment->getResultData()->ShippingDeliveryVO->shippingDeliveryDetailVO->shippingDeliveryItemDetailVO->invDocCargoVOArray);

                            foreach ($queryShipment  as $shipment) {
                                
                            }
                        } else {
                        ?>
                            <form action="" method="POST" role="form">
                                <div class="row align-items-center g-3 g-sm-4 pb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label" for="new-pass">KEY</label>
                                        <div class="password-toggle">
                                            <input class="form-control" type="text" id="new-pass" name="key">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end pt-3">
                                        <button class="btn btn-primary ms-3" type="submit">Sorgula</button>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>

                        <!-- <div class="alert alert-info d-flex mb-0" role="alert"><i class="ai-circle-info fs-xl"></i>
                            <div class="ps-2">Fill in the information 100% to receive more suitable offers.<a class="alert-link ms-1" href="account-settings.html">Go to settings!</a></div>
                        </div> -->
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


<script>
    $('#yurticiApi').submit(function(event) {
        event.preventDefault();
        // var form = new FormData(this);
        var form = $(this).serializeArray();
        $.ajax({
            method: "POST",
            url: "ajax.php",
            data: form
        }).done(function(cevap) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Bilgilerin Kaydedildi...',
                showConfirmButton: false,
                timer: 1500
            })
        })
    })


    // $("#yurticiApi").submit(function(event) {
    //     event.preventDefault();
    //     var form = $(this).serializeArray();
    //     $.ajax({
    //         method: "POST",
    //         url: "ajax.php",
    //         data: form
    //     }).done(function(sonuc) {
    //         $("textaarea").val("");
    //         $("tbody").html(sonuc);
    //     });
    // });
</script>


<?php
require_once 'sections/footer.php';
?>