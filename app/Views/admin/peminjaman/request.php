<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Peminjaman', 'description' => 'Kelola data request peminjaman tabung oleh mitra']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content section -->
<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Tabel Request Peminjaman Tabung oleh Mitra
            </h5>
            <a href="<?= base_url('/admin/peminjaman/new'); ?>" class="btn btn-sm icon icon-left btn-danger">
                <i class="bi bi-person-plus"></i>
                Tambah
            </a>
        </div>
        <div class="card-body" style="overflow: auto;">
            <table id="table1" class="table table-stripped nowrap display" style="width:100%">
                <thead class="fixed-header">
                    <tr>
                        <th>No.</th>
                        <th>Kode Peminjaman</th>
                        <th>Nama Mitra</th>
                        <th>Tanggal Pengajuan</th>
                        <?php foreach ($tabungs as $tabung) : ?>
                            <th>
                                <?php if ($tabung->category_massa == 'kubik') : ?>
                                    <?= $tabung->name . ' ' . $tabung->category_name ?>m<sup>3</sup>
                                <?php elseif ($tabung->category_massa == 'kilogram') : ?>
                                    <?= $tabung->name . ' ' . $tabung->category_name ?>Kg
                                <?php else : ?>
                                    <?= $tabung->name . ' ' . $tabung->category_name ?>
                                <?php endif; ?>
                            </th>
                        <?php endforeach; ?>
                        <th>Aksi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $groupedPeminjamans = [];
                    foreach ($peminjamans as $peminjaman) :
                        if ($peminjaman->status != 'done') :
                            if (!isset($groupedPeminjamans[$peminjaman->loan_code])) :
                                $groupedPeminjamans[$peminjaman->loan_code] = [
                                    'mitra_name' => $peminjaman->mitra_name,
                                    'loan_code' => $peminjaman->loan_code,
                                    'status' => $peminjaman->status,
                                    'approval' => $peminjaman->approval,
                                    'created_at' => $peminjaman->created_at,
                                    'tabungs' => [],
                                ];
                            endif;

                            $groupedPeminjamans[$peminjaman->loan_code]['tabungs'][$peminjaman->tabung_id] = $peminjaman->amount;
                        endif;
                    endforeach;

                    foreach ($groupedPeminjamans as $groupedPeminjaman) :
                    ?>
                        <tr id="peminjaman<?= $groupedPeminjaman['loan_code'] ?>">
                            <td><?= $no++ ?></td>
                            <td><?= $groupedPeminjaman['loan_code'] ?></td>
                            <td><?= $groupedPeminjaman['mitra_name'] ?></td>
                            <td><?= $groupedPeminjaman['created_at'] ?></td>
                            <?php
                            foreach ($tabungs as $tabung) :
                                $amount = isset($groupedPeminjaman['tabungs'][$tabung->id]) ? $groupedPeminjaman['tabungs'][$tabung->id] : 0;
                                echo '<td>' . $amount . '</td>';
                            endforeach;
                            ?>
                            <td id="approval<?= $groupedPeminjaman['loan_code'] ?>" class="text-left">
                                <?php if ($groupedPeminjaman['approval'] == null) : ?>
                                    <button class="btn btn-success approve-btn" type="submit" data-code-peminjaman="<?= $groupedPeminjaman['loan_code'] ?>" data-mitra-name="<?= $groupedPeminjaman['mitra_name'] ?>">Approve</button>
                                    <button class="btn btn-danger reject-btn" type="submit" data-code-peminjaman="<?= $groupedPeminjaman['loan_code'] ?>" data-mitra-name="<?= $groupedPeminjaman['mitra_name'] ?>">Reject</button>
                                <?php elseif ($groupedPeminjaman['approval'] == 'approved') : ?>
                                    <a type="button" class="btn btn-outline-info revert-btn" data-code-peminjaman="<?= $groupedPeminjaman['loan_code'] ?>" data-mitra-name="<?= $groupedPeminjaman['mitra_name'] ?>">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                        Revert
                                    </a>
                                    <a class="btn btn-success">Approved</a>
                                <?php elseif ($groupedPeminjaman['approval'] == 'rejected') : ?>
                                    <a type="button" class="btn btn-outline-info revert-btn" data-code-peminjaman="<?= $groupedPeminjaman['loan_code'] ?>" data-mitra-name="<?= $groupedPeminjaman['mitra_name'] ?>">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                        Revert
                                    </a>
                                    <button class="btn btn-danger delete-peminjaman-btn" type="submit" data-code-peminjaman="<?= $groupedPeminjaman['loan_code'] ?>" data-mitra-name="<?= $groupedPeminjaman['mitra_name'] ?>">Delete</button>
                                <?php endif; ?>
                            </td>
                            <td id="status<?= $groupedPeminjaman['loan_code'] ?>">
                                <select id="status-progress<?= $groupedPeminjaman['loan_code'] ?>" class="choices form-select select-status" data-code-peminjaman="<?= $groupedPeminjaman['loan_code'] ?>" data-mitra-name="<?= $groupedPeminjaman['mitra_name'] ?>" value="<?= $groupedPeminjaman['status'] ?>" <?= $groupedPeminjaman['approval'] != 'approved' ? 'disabled' : ''; ?>>
                                    <option value="waiting" <?= $groupedPeminjaman['status'] == 'waiting' ? 'selected' : ''; ?>>Menunggu</option>
                                    <option value="sent" <?= $groupedPeminjaman['status'] == 'sent' ? 'selected' : ''; ?>>Dikirim</option>
                                    <option value="done" <?= $groupedPeminjaman['status'] == 'done' ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
<!-- Basic Tables end -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $('#table1').show()
    let jquery_datatable = $("#table1").DataTable({
        "columnDefs": [{
            "type": "string",
            "targets": "_all"
        }],
        "order":  false,
        fixedColumns: {
            start: 3,
            end: 0
        },
        paging: false,
        scrollCollapse: true,
        scrollX: true,
    })

    const setTableColor = () => {
        document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
            dt.classList.add('pagination-primary')
        })
    }
    setTableColor()
    jquery_datatable.on('draw', setTableColor)
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.approve-btn', function(e) {
            var loan_code = $(this).data('code-peminjaman');
            var mitra_name = $(this).data('mitra-name');
            $.ajax({
                url: '<?= base_url() ?>admin/peminjaman/approve',
                type: 'POST',
                data: {
                    "loan_code": loan_code
                },
                success: function(response) {
                    response = JSON.parse(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Permintaan peminjaman disetujui',
                        showConfirmButton: false,
                        timer: 2000
                    })

                    $('#approval' + loan_code).empty();
                    $('#approval' + loan_code).html(
                        `
                            <a type="button" class="btn btn-outline-info revert-btn" data-code-peminjaman="${loan_code}" data-mitra-name="${mitra_name}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Revert
                            </a>
                            <a class="btn btn-success">Approved</a>
                        `
                    );
                    $('#status' + loan_code).empty();
                    $('#status' + loan_code).html(
                        `
                            <select id="status-progress${loan_code}" name="status-progress${loan_code}" class="choices form-select select-status" data-code-peminjaman="${loan_code}" data-mitra-name="${mitra_name}" value="waiting">
                                <option value="waiting">Menunggu</option>
                                <option value="sent">Dikirim</option>
                                <option value="done">Selesai</option>
                            </select>
                        `
                    );
                    $('.select-status').each(function() {
                        var select_element = $(this);
                        select_element.data('original-status', select_element.val());
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });

        });
        $(document).on('click', '.reject-btn', function(e) {
            var loan_code = $(this).data('code-peminjaman');
            var mitra_name = $(this).data('mitra-name');
            $.ajax({
                url: '<?= base_url() ?>admin/peminjaman/reject',
                type: 'POST',
                data: {
                    "loan_code": loan_code
                },
                success: function(response) {
                    response = JSON.parse(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Permintaan peminjaman ditolak',
                        showConfirmButton: false,
                        timer: 2000
                    })

                    $('#approval' + loan_code).empty();
                    $('#approval' + loan_code).html(
                        `
                            <a type="button" class="btn btn-outline-info revert-btn" data-code-peminjaman="${loan_code}" data-mitra-name="${mitra_name}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Revert
                            </a>
                            <button class="btn btn-danger delete-peminjaman-btn" type="submit" data-code-peminjaman="${loan_code}" data-mitra-name="${mitra_name}">Delete</button>
                        `
                    );
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });

        });



        $(document).on('click', '.revert-btn', function(e) {
            var loan_code = $(this).data('code-peminjaman');
            var mitra_name = $(this).data('mitra-name');
            if ($("#status-progress" + loan_code).val() != 'waiting') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Approval tidak dapat diubah ketika status bukan menunggu',
                    showConfirmButton: false,
                    timer: 2000
                })
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Yakin?',
                    text: 'Merubah status persetujuan ' + mitra_name,
                    showCancelButton: true, // Menampilkan tombol pembatalan
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Revert!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url() ?>admin/peminjaman/revert',
                            type: 'POST',
                            data: {
                                "loan_code": loan_code
                            },
                            success: function(response) {
                                response = JSON.parse(response);
                                console.log('berhasil revert ' + loan_code);
                                $('#approval' + loan_code).empty();
                                $('#approval' + loan_code).html(
                                    `
                                        <button class="btn btn-success approve-btn" type="submit" data-code-peminjaman="${loan_code}" data-mitra-name="${mitra_name}">Approve</button>
                                        <button class="btn btn-danger reject-btn" type="submit" data-code-peminjaman="${loan_code}" data-mitra-name="${mitra_name}">Reject</button>
                                        
                                    `
                                );
                                $('#status' + loan_code).empty();
                                $('#status' + loan_code).html(
                                    `
                                        <select id="status-progress${loan_code}" name="status-progress${loan_code}" class="choices form-select select-status" data-code-peminjaman="${loan_code}" data-mitra-name="${mitra_name}" value="waiting" disabled>
                                            <option value="waiting">Menunggu</option>
                                            <option value="sent">Dikirim</option>
                                            <option value="done">Selesai</option>
                                        </select>
                                    `
                                );
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error(textStatus, errorThrown);
                            }
                        });
                    }
                });

            }
        });
    });

    $(document).on('click', '.delete-peminjaman-btn', function(e) {
        var mitra_name = $(this).data('mitra-name');
        var loan_code = $(this).data('code-peminjaman');
        Swal.fire({
            icon: 'warning',
            title: 'Yakin?',
            text: 'Data pengajuan ' + mitra_name + ' dengan kode ' + loan_code + ' akan dihapus secara permanen',
            showCancelButton: true, // Menampilkan tombol pembatalan
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>admin/peminjaman/delete/' + loan_code,
                    type: 'DELETE',
                    success: function(response) {
                        response = JSON.parse(response);
                        Swal.fire({
                            icon: response.status,
                            title: response.title,
                            text: response.message + ' ' + mitra_name,
                        });
                        if (response.status == 'success') {
                            $('#peminjaman' + loan_code).remove();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
            }
        });
    });

    $('.select-status').each(function() {
        var select_element = $(this);
        select_element.data('original-status', select_element.val());
    });

    $(document).on('change', '.select-status', function() {
        var selected_status = $(this).val();
        var original_status = $(this).data('original-status');

        var loan_code = $(this).data('code-peminjaman');
        var mitra_name = $(this).data('mitra-name');

        Swal.fire({
            icon: 'warning',
            title: 'Yakin?',
            text: 'Mengubah status ' + mitra_name + ' dengan kode ' + loan_code + ' menjadi ' + selected_status,
            showCancelButton: true, // Menampilkan tombol pembatalan
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>admin/peminjaman/change-status',
                    type: 'POST',
                    data: {
                        loan_code: loan_code,
                        selected_status: selected_status
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status permintaan ' + mitra_name + ' kode ' + loan_code + ' berhasil diubah',
                        });
                        $('.select-status').each(function() {
                            var select_element = $(this);
                            select_element.data('original-status', select_element.val());
                        });
                        if (selected_status == 'done') {
                            $('#peminjaman' + loan_code).remove();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
            } else {
                $(this).val(original_status);

            }
        });
    });
</script>


<?= $this->endSection(); ?>