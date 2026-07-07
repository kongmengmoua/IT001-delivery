<?php
require_once '../auth/check-login.php';
include_once 'process.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once '../includes/header.php' ?>
</head>

<body class="sb-nav-fixed">
    <!-- ດຶງເມນູເຂົ້າມາ  -->
    <?php include_once '../includes/menu.php' ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="row mt-4">

                    <div class="col-md-4">
                        <fieldset class="border border-primary shadow p-2 px-4 pb-4" style="border-radius: 15px; background-color: #E7E9EB">
                            <legend class="float-none w-auto p-2 h5">ຈັດການຂໍ້ມູນພະແນກ</legend>
                            <form action="./" method="post">

                                <div class="mb-3">
                                    <label for="dno" class="form-label">ລະຫັດພະແນກ:</label>
                                    <input type="text" class="form-control <?= empty($error_dno) ? '' : 'is-invalid' ?>" id="dno" placeholder="ປ້ອນລະຫັດພະແນກ 3 ຫຼັກ" name="dno" value="<?= $dno ?? null ?>" maxlength="6" required <?= (@$_GET['action'] === 'edit' || $error_edit) ? 'readonly' : '' ?>>
                                    <div class="invalid-feedback d-block">
                                        <!-- ສະແດງກໍລະນີລະຫັດພະແນກມີໃນລະບົບແລ້ວ -->
                                        <?= $error_dno ?? null ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">ຊື່ພະແນກ:</label>
                                    <input type="text" class="form-control <?= empty($error_name) ? '' : 'is-invalid' ?>" id="name" placeholder="ປ້ອນຊື່ພະແນກ" name="name" value="<?= $name ?? null ?>" required>
                                    <div class="invalid-feedback d-block">
                                        <!-- ສະແດງກໍລະນີຊື່ພະແນກມີໃນລະບົບແລ້ວ -->
                                        <?= $error_name ?? null ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="loc" class="form-label">ສະຖານທີ່:</label>
                                    <input type="text" class="form-control" id="loc" placeholder="ປ້ອນທີ່ຢູ່ຂອງພະແນກ" name="loc" value="<?= $loc ?? null ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="incentive" class="form-label">ເງິນບໍລິຫານພະແນກ:</label>
                                    <input type="text" class="form-control" id="incentive" placeholder="ປ້ອນເງິນບໍລິຫານພະແນກ" name="incentive" value="<?= $incentive ?? null ?>" required>
                                </div>

                                <div class="mb-3">
                                    <?php
                                    if (@$_GET['action'] === 'edit' || $error_edit) {
                                        echo '<button type="submit" name="btnEdit" class="btn btn-info" style="width: 100px;"><i class="fas fa-edit"></i>&nbsp;&nbsp;ແກ້ໄຂ</button>';
                                    } else {
                                        echo '<button type="submit" name="btnAdd" class="btn btn-primary" style="width: 100px;"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;ເພີ້ມ</button>';
                                    }
                                    ?>
                                    <a href="./" class="btn btn-warning" style="width: 100px;"><i class="fas fa-sync"></i>&nbsp;&nbsp;ຍົກເລີກ</a>
                                </div>

                            </form>

                        </fieldset>
                    </div>

                    <div class="col-md-8 mt-4">
                        <fieldset class="border border-primary shadow p-2 px-4 pb-4" style="border-radius: 15px;">

                            <table id="example" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ລໍາດັບ</th>
                                        <th class="text-center">ລະຫັດພະແນກ</th>
                                        <th class="text-center">ຊື່ພະແນກ</th>
                                        <th class="text-center">ທີ່ຢູ່</th>
                                        <th class="text-center">ເງິນບໍລິຫານ</th>
                                        <th class="text-center">Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT *FROM dept";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $numRow = 0;
                                    foreach ($rows as $value) :
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= ++$numRow ?></td>
                                            <td class="text-center"><?= $value['dno'] ?></td>
                                            <td><?= $value['name'] ?></td>
                                            <td><?= $value['loc'] ?></td>
                                            <td class="text-end"><?= number_format($value['incentive']) ?></td>
                                            <td class="text-center">
                                                <a href="./?action=edit&dno=<?= $value['dno'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="ແກ້ໄຂ"><i class="fas fa-edit text-success"></i></a>
                                                <a href="#" onclick="dataDelete('<?= $value['dno'] ?>')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ລືບຂໍ້ມູນ"><i class="fas fa-trash-alt text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                        </fieldset>
                    </div>

                </div>
            </div>
        </main>
        <!-- footer -->
        <?php include_once '../includes/footer.php' ?>

    </div>

</body>

</html>

<script>
    /* ບໍ່ໃຫ້ມັນຊັບມິດຄືນ*/
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    /*ໃຊ້ງານdatable ຕາຕະລາງ id ຊື່ example */
    new DataTable('#example', {
        pageLength: 10,
        language: {
            lengthMenu: "ສະແດງ _MENU_ ແຖວຕໍ່ໜ້າ",
            zeroRecords: "ບໍ່ພົບຂໍ້ມູນທີ່ຄົ້ນຫາ",
            info: "ສະແດງແຖວທີ _START_ ຫາ _END_ ຈາກທັງໝົດ _TOTAL_ ແຖວ",
            infoEmpty: "ບໍ່ມີຂໍ້ມູນສະແດງ",
            infoFiltered: "(ກັ່ນຕອງຈາກທັງໝົດ _MAX_ ແຖວ)",
            search: "ຄົ້ນຫາຂໍ້ມູນ:",
            paginate: {
                first: "ໜ້າທຳອິດ",
                last: "ໜ້າສຸດທ້າຍ",
                next: "ຖັດໄປ",
                previous: "ກ່ອນໜ້າ"
            }
        }
    });

    /*ໃຊ້ງານປ໊ອບອັບແກ້ໄຂ ລືບຂໍ້ມູນ */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    /*ກໍານົດຫ້ອງເງິນບໍລິຫານໃຫ້ຈຸດອັດຕະໂນມັດເມື່ອຮອດຫຼັກພັນ */
    $('#incentive').priceFormat({
        prefix: '',
        thousandsSeparator: ',',
        centsLimit: 0

    });

    /**ຟັງຊັນທີ່ໃຊ້ລືບຂໍ້ມູນ */
    function dataDelete(id) {
        //alert(id);
        Swal.fire({
            title: 'ຕ້ອງການລືບແທ້ບໍ?',
            text: `ຂໍ້ມູນລະຫັດ ${id} ຈະຖືກລືບຖາວອນ`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ຕົກລົງ',
            cancelButtonText: 'ຍົກເລີກ',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then(result => {
            if (result.isConfirmed) {
                $.post("delete.php", {
                    id: id
                }, function(res) {
                    if (res) {
                        Swal.fire({
                            title: "ຜິດພາດ",
                            text: res,
                            icon: "error",
                            confirmButtonText: 'ຕົກລົງ'
                        });
                    } else {
                        Swal.fire({
                            title: 'ສໍາເລັດ',
                            text: 'ຂໍ້ມູນຖືກລືບອອກຈາກຖານຂໍ້ມູນແລ້ວ',
                            icon: 'success',
                            confirmButtonText: 'ຕົກລົງ',
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        });
    }
</script>