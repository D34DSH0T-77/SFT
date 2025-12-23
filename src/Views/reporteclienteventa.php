   <table class="custom-table" id="myTable">
       <thead>
           <tr>
               <th width="5%" class="text-center no-ordenar">#</th>
               <th class="text-start no-ordenar">Cliente</th>
               <th width="15%" class="text-center no-ordenar">Estado</th>
               <th width="15%" class="text-center no-ordenar">Compras</th>
               <th width="20%" class="text-end no-ordenar">Total Gastado USD</th>
               <th width="20%" class="text-end no-ordenar">Total Gastado BS</th>
           </tr>
       </thead>
       <tbody>
           <?php if (isset($clientes) && !empty($clientes)): ?>
               <?php $contador = 1; ?>
               <?php foreach ($clientes as $c): ?>
                   <tr>
                       <td class="text-center"><?= $contador++ ?></td>
                       <td class="text-start">
                           <div class="d-flex align-items-center">

                               <?= $c->nombre . ' ' . $c->apellido ?>
                           </div>
                       </td>
                       <td class="text-center">
                           <span class="badge bg-<?= $c->estado == 'Activo' ? 'success' : 'secondary' ?>"><?= $c->estado ?></span>
                       </td>
                       <td class="text-center">
                           <span class="badge bg-primary rounded-pill"><?= $c->total_compras ?></span>
                       </td>
                       <td class="text-end fw-bold text-success">$<?= number_format($c->total_gastado_usd, 2) ?></td>
                       <td class="text-end">Bs <?= number_format($c->total_gastado_bs, 2) ?></td>
                   </tr>
               <?php endforeach; ?>
           <?php endif; ?>
       </tbody>
   </table>