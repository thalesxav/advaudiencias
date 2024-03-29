 <?php
 //var_dump($info);
 ?>

 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

<div class="datalist">
    <table id="example1" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="50">ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Permissão</th>
                <th width="120">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($info as $row): ?>
            <tr>
            	<td>
					<?=$row['admin_id']?>
                </td>
                <!--<td>
					<h4 class="m0 mb5"><?=$row['firstname']?> <?=$row['lastname']?></h4>
                    <small class="text-muted"><?=$row['admin_role_title']?></small>
                </td>//-->
                <td>
                    <?=$row['username']?>
                </td> 
                <td>
					<?=$row['email']?>
                </td>
                <td>
                    <?= (strpos($row['roles_ids'], '1') !== false) ? '<span class="btn btn-default btn-flat btn-xs" >Admin</span>' : '' ?>
                    <?= (strpos($row['roles_ids'], '2') !== false) ? '<span class="btn btn-default btn-flat btn-xs" >Cadastro de Advogados</span>' : '' ?>
                    <?= (strpos($row['roles_ids'], '3') !== false) ? '<span class="btn btn-default btn-flat btn-xs" >Cadastro de Audiências</span>' : '' ?>
                    <?= (strpos($row['roles_ids'], '4') !== false) ? '<span class="btn btn-default btn-flat btn-xs">Relatório de Apuração</span>' : '' ?>              
                </td>
                <!--<td>
                    <button class="btn btn-xs btn-success"><?=$row['admin_role_title']?></button>
                </td> 
                <td><input class='tgl tgl-ios tgl_checkbox' 
                    data-id="<?=$row['admin_id']?>" 
                    id='cb_<?=$row['admin_id']?>' 
                    type='checkbox' <?php echo ($row['is_active'] == 1)? "checked" : ""; ?> />
                    <label class='tgl-btn' for='cb_<?=$row['admin_id']?>'></label>
                </td>//-->
                <td>
                    <a href="<?php echo site_url("admin/admin/edit/".$row['admin_id']); ?>" class="btn btn-warning btn-xs mr5" >
                    <i class="fa fa-edit"></i>
                    </a>
                    <a href="<?php echo site_url("admin/admin/delete/".$row['admin_id']); ?>" onclick="return confirm('Deseja deletar o registro?')" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script> 