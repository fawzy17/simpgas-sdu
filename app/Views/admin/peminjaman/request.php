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
        <div class="card-body">
            <table id="table1" class="table table-stripped" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Peminjaman</th>
                        <th>Mitra</th>
                        <?php foreach ($tabungs as $tabung) : ?>
                            <th><?= $tabung->name ?></th>
                        <?php endforeach; ?>
                        <th>Aksi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($peminjamans as $peminjaman) :
                        if ($peminjaman->status != 'done') :
                    ?>
                            <tr id="peminjaman<?= $peminjaman->id ?>">
                                <td><?= $no++ ?></td>
                                <td><?= $peminjaman->loan_code ?></td>
                                <td><?= $peminjaman->mitra_name ?></td>
                                <?php
                                foreach ($tabungs as $tabung) :
                                    if ($peminjaman->tabung_id == $tabung->id) :
                                        echo '<td>' . $peminjaman->amount . '</td>';
                                    else :
                                        echo '<td>0</td>';
                                    endif;
                                endforeach;
                                ?>
                                <td id="approval<?= $peminjaman->id ?>" class="text-left">
                                    <?php if ($peminjaman->approval == null) : ?>
                                        <button class="btn btn-success approve-btn" type="submit" data-id-peminjaman="<?= $peminjaman->id ?>" data-mitra-name="<?= $peminjaman->mitra_name ?>">Approve</button>
                                        <button class="btn btn-danger reject-btn" type="submit" data-id-peminjaman="<?= $peminjaman->id ?>" data-code-peminjaman="<?= $peminjaman->loan_code ?>" data-mitra-name="<?= $peminjaman->mitra_name ?>">Reject</button>
                                    <?php elseif ($peminjaman->approval == 'approved') : ?>
                                        <a type="button" class="btn btn-outline-info revert-btn" data-id-peminjaman="<?= $peminjaman->id ?>" data-code-peminjaman="<?= $peminjaman->loan_code ?>" data-mitra-name="<?= $peminjaman->mitra_name ?>">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            Revert
                                        </a>
                                        <a class="btn btn-success">Approved</a>
                                    <?php elseif ($peminjaman->approval == 'rejected') : ?>
                                        <a type="button" class="btn btn-outline-info revert-btn" data-id-peminjaman="<?= $peminjaman->id ?>" data-code-peminjaman="<?= $peminjaman->loan_code ?>" data-mitra-name="<?= $peminjaman->mitra_name ?>">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            Revert
                                        </a>
                                        <button class="btn btn-danger delete-peminjaman-btn" type="submit" data-id-peminjaman="<?= $peminjaman->id ?>" data-code-peminjaman="<?= $peminjaman->loan_code ?>" data-mitra-name="<?= $peminjaman->mitra_name ?>">Delete</button>
                                    <?php endif; ?>
                                </td>
                                <td id="status<?= $peminjaman->id ?>">
                                    <select id="status-progress<?= $peminjaman->id ?>" name="status-progress<?= $peminjaman->id ?>" class="choices form-select select-status" data-id-peminjaman="<?= $peminjaman->id ?>" data-code-peminjaman="<?= $peminjaman->loan_code ?>" data-mitra-name="<?= $peminjaman->mitra_name ?>" value="<?= $peminjaman->status ?>" <?= $peminjaman->approval != 'approved' ? 'disabled' : ''; ?>>
                                        <option value="waiting" <?= $peminjaman->status == 'waiting' ? 'selected' : ''; ?>>Menunggu</option>
                                        <option value="sent" <?= $peminjaman->status == 'sent' ? 'selected' : ''; ?>>Dikirim</option>
                                        <option value="done" <?= $peminjaman->status == 'done' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                </td>
                            </tr>
                    <?php
                        endif;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
<!-- Basic Tables end -->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    let jquery_datatable = $("#table1").DataTable({
        "fixedColumns": {
            start: 1,
            end: 0
        },
        "responsive": true,
        "columnDefs": [{
            "type": "string",
            "targets": "_all"
        }],
        "scrollX": true,
        "autoWidth": true,
        "scrollCollapse": true,

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
            var id_peminjaman = $(this).data('id-peminjaman');
            var code_peminjaman = $(this).data('code-peminjaman');
            var mitra_name = $(this).data('mitra-name');
            $.ajax({
                url: '<?= base_url() ?>admin/peminjaman/approve',
                type: 'POST',
                data: {
                    "id_peminjaman": id_peminjaman
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

                    $('#approval' + response.id).empty();
                    $('#approval' + response.id).html(
                        `
                            <a type="button" class="btn btn-outline-info revert-btn" data-id-peminjaman="${response.id}" data-code-peminjaman="${code_peminjaman}" data-mitra-name="${mitra_name}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Revert
                            </a>
                            <a class="btn btn-success">Approved</a>
                        `
                    );
                    $('#status' + response.id).empty();
                    $('#status' + response.id).html(
                        `
                            <select id="status-progress${response.id}" name="status-progress${response.id}" class="choices form-select select-status" data-id-peminjaman="${response.id}" data-code-peminjaman="${code_peminjaman}" data-mitra-name="${mitra_name}" value="waiting">
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

        });
        $(document).on('click', '.reject-btn', function(e) {
            var id_peminjaman = $(this).data('id-peminjaman');
            var code_peminjaman = $(this).data('code-peminjaman');
            var mitra_name = $(this).data('mitra-name');
            $.ajax({
                url: '<?= base_url() ?>admin/peminjaman/reject',
                type: 'POST',
                data: {
                    "id_peminjaman": id_peminjaman
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

                    $('#approval' + response.id).empty();
                    $('#approval' + response.id).html(
                        `
                            <a type="button" class="btn btn-outline-info revert-btn" data-id-peminjaman="${response.id}" data-code-peminjaman="${code_peminjaman}" data-mitra-name="${mitra_name}">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Revert
                            </a>
                            <button class="btn btn-danger delete-peminjaman-btn" type="submit" data-id-peminjaman="${response.id}" data-code-peminjaman="${code_peminjaman}" data-mitra-name="${mitra_name}">Delete</button>
                        `
                    );
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });

        });



        $(document).on('click', '.revert-btn', function(e) {
            var id_peminjaman = $(this).data('id-peminjaman');
            var code_peminjaman = $(this).data('code-peminjaman');
            var mitra_name = $(this).data('mitra-name');
            if ($("#status-progress" + id_peminjaman).val() != 'waiting') {
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
                                "id_peminjaman": id_peminjaman
                            },
                            success: function(response) {
                                response = JSON.parse(response);
                                console.log('berhasil revert ' + response.id);
                                $('#approval' + response.id).empty();
                                $('#approval' + response.id).html(
                                    `
                                        <button class="btn btn-success approve-btn" type="submit" data-id-peminjaman="${id_peminjaman}" data-code-peminjaman="${code_peminjaman}" data-mitra-name="${mitra_name}">Approve</button>
                                        <button class="btn btn-danger reject-btn" type="submit" data-id-peminjaman="${id_peminjaman}" data-code-peminjaman="${code_peminjaman}" data-mitra-name="${mitra_name}">Reject</button>
                                        
                                    `
                                );
                                $('#status' + response.id).empty();
                                $('#status' + response.id).html(
                                    `
                                        <select id="status-progress${response.id}" name="status-progress${response.id}" class="choices form-select select-status" data-id-peminjaman="${response.id}" data-code-peminjaman="${code_peminjaman}" data-mitra-name="${mitra_name}" value="waiting" disabled>
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
        var id_peminjaman = $(this).data('id-peminjaman');
        var mitra_name = $(this).data('mitra-name');
        var code_peminjaman = $(this).data('code-peminjaman');
        Swal.fire({
            icon: 'warning',
            title: 'Yakin?',
            text: 'Data pengajuan ' + mitra_name + ' dengan kode ' + code_peminjaman + ' akan dihapus secara permanen',
            showCancelButton: true, // Menampilkan tombol pembatalan
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>admin/peminjaman/delete/' + id_peminjaman,
                    type: 'DELETE',
                    success: function(response) {
                        response = JSON.parse(response);
                        Swal.fire({
                            icon: response.status,
                            title: response.title,
                            text: response.message + ' ' + mitra_name,
                        });
                        if (response.status == 'success') {
                            $('#peminjaman' + response.id).remove();
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

        var id_peminjaman = $(this).data('id-peminjaman');
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
                        id_peminjaman: id_peminjaman,
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