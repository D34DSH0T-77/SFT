<div>

    <table>
        <thead>
            <tr>
                <th>
                    nombre y apellido
                </th>
                <th>

                    estado

                </th>
            </tr>

        </thead>

        <tbody>
            <?php if (isset($clientes) && !empty($clientes)) : ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td>
                            <?= $cliente->nombre . ' ' . $cliente->apellido ?>

                        </td>

                        <td>
                            <?= $cliente->estado ?>
                        </td>


                    </tr>

                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>


</div>