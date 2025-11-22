<div class="mt-4 d-flex justify-content-center">
    <?php if (isset($paginator)): ?>
        <form id="paginationForm" action="<?= RUTA_BASE ?>inventario" method="POST">
            <input type="hidden" name="page" id="pageValue">
        </form>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($paginator->getPrevUrl()): ?>
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="submitPagination('<?= $paginator->getPrevUrl(); ?>'); return false;" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php foreach ($paginator->getPages() as $page): ?>
                    <?php if ($page['url']): ?>
                        <li class="page-item <?= $page['isCurrent'] ? 'active' : ''; ?>">
                            <a class="page-link" href="#" onclick="submitPagination('<?= $page['url']; ?>'); return false;"><?= $page['num']; ?></a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#"><?= $page['num']; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($paginator->getNextUrl()): ?>
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="submitPagination('<?= $paginator->getNextUrl(); ?>'); return false;" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>