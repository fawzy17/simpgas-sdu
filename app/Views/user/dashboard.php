<?= $this->extend('layouts/main'); ?>
<?= $this->section('heads'); ?>

<?= $this->endSection(); ?>
<?= $this->section('page_title'); ?>
<?= view_cell('\App\Libraries\HeadingPointer:show', ['title_header' => 'Dashboard', 'description' => 'Kelola data Anda disini']); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Basic Tables start -->
<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                jQuery Datatable
            </h5>
        </div>
        <div class="card-body">
            <table id="table1" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Namedada ad aw da</th>
                        <th>Name</th>
                        <th>Name</th>
                        <th>Name</th>
                        <th>Name</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>City</th>
                        <th>City</th>
                        <th>City</th>
                        <th>City</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Status</th>
                        <th>Status</th>
                        <th>Status</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>vehicula .aliquet@</td>
                        <td>076 4820 8838</td>
                        <td>Offenburg</td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>vehicula .aliquet@</td>
                        <td>076 4820 8838</td>
                        <td>Offenburg</td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>Graiden</td>
                        <td>vehicula .aliquet@</td>
                        <td>076 4820 8838</td>
                        <td>Offenburg</td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</section>
<!-- Basic Tables end -->

<form action="<?= base_url('/send-email'); ?>" method="POST">
    <input id="to" name="to" type="text">
    <label for="to">to</label>
    <input id="subject" name="subject" type="text">
    <label for="subject">subject</label>
    <input id="message" name="message" type="text">
    <label for="message">message</label>

    <button type="submit">Submit</button>
</form>


<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    let jquery_datatable = $("#table1").DataTable({
        responsive: true,
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
    $(() => {
        <?php if (session()->has('success_message')) : ?>
            Swal.fire({
                icon: 'success',
                text: '<?= session()->getFlashdata('success_message') ?>',
                showConfirmButton: false,
                timer: 2000
            })
        <?php endif; ?>
    })
    $(() => {
        <?php if (session()->has('error_message')) : ?>
            Swal.fire({
                icon: 'error',
                text: '<?= session()->getFlashdata('error_message') ?>',
                showConfirmButton: false,
                timer: 2000
            })
        <?php endif; ?>
    })
</script>

<?= $this->endSection(); ?>