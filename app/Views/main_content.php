<?php echo $this->extend('plantilla/layout'); ?>

<?php echo $this->section('contenido'); ?>
<table>
    <thead>
        <th>Nombre</th>
        <th>Stock</th>
        <th>Precio</th>
    </thead>
    <tbody></tbody>
</table>
<?php echo $this->endSection(); ?>

<?php echo $this->section('jsCode'); ?>
<script>alert('HOLA JS');</script>
<?php echo $this->endSection(); ?>