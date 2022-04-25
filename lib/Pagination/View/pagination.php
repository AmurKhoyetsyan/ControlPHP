<? if($pagination->show()): ?>
    <nav aria-label="Pagination">
        <ul class="pagination justify-content-end">
            <li class="page-item <?= $pagination->prevActive() ? "" : "disabled" ?>">
                <a class="page-link" href="<?= $pagination->prev()?>" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <?php if($pagination->issetPages()): ?>
                <?php if($pagination->getLen() <= ($pagination->getMarker() * 2)): ?>
                    <?php for($i = 0; $i < $pagination->getLen(); $i++): ?>
                        <li class="page-item <?= $pagination->itemActive($i) ? "active": "" ?>">
                            <a class="page-link" href="<?= $pagination->setUrl($i) ?>">
                                <?= $pagination->getItemNumber($i) ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                <?php elseif($pagination->thisPage() > $pagination->getMarker() && $pagination->thisPage() < $pagination->getLen() - $pagination->getMarker()): ?>
                    <li class="page-item <?= $pagination->itemActive(0) ? "active": "" ?>">
                        <a class="page-link" href="<?= $pagination->setUrl(0) ?>">
                            <?= $pagination->getItemNumber(0) ?>
                        </a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <?php for($i = $pagination->thisPage() - ($pagination->getMarker() - 1); $i < $pagination->thisPage() + ($pagination->getMarker() - 1); $i++): ?>
                        <li class="page-item <?= $pagination->itemActive($i) ? "active": "" ?>">
                            <a class="page-link" href="<?= $pagination->setUrl($i) ?>">
                                <?= $pagination->getItemNumber($i) ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item <?= $pagination->itemActive($pagination->getLen() - 1) ? "active": "" ?>">
                        <a class="page-link" href="<?= $pagination->setUrl($pagination->getLen() - 1) ?>">
                            <?= $pagination->getItemNumber($pagination->getLen() - 1) ?>
                        </a>
                    </li>
                <?php elseif($pagination->thisPage() <= $pagination->getMarker() && $pagination->getLen() >= $pagination->getMarker() + 2): ?>
                    <?php for($i = 0; $i < $pagination->getMarker() + 2; $i++): ?>
                        <li class="page-item <?= $pagination->itemActive($i) ? "active": "" ?>">
                            <a class="page-link" href="<?= $pagination->setUrl($i) ?>">
                                <?= $pagination->getItemNumber($i) ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item <?= $pagination->itemActive($pagination->getLen() - 1) ? "active": "" ?>">
                        <a class="page-link" href="<?= $pagination->setUrl($pagination->getLen() - 1) ?>">
                            <?= $pagination->getItemNumber($pagination->getLen() - 1) ?>
                        </a>
                    </li>
                <?php elseif($pagination->thisPage() >= $pagination->getLen() - $pagination->getMarker()): ?>
                    <li class="page-item <?= $pagination->itemActive(0) ? "active": "" ?>">
                        <a class="page-link" href="<?= $pagination->setUrl(0) ?>">
                            <?= $pagination->getItemNumber(0) ?>
                        </a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <?php for($i = $pagination->getLen() - ($pagination->getMarker() + 2); $i < $pagination->getLen(); $i++): ?>
                        <li class="page-item <?= $pagination->itemActive($i) ? "active": "" ?>">
                            <a class="page-link" href="<?= $pagination->setUrl($i) ?>">
                                <?= $pagination->getItemNumber($i) ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                <?php endif; ?>
            <?php else: ?>
                <?php if($pagination->getLen() <= ($pagination->getMarker() * 2)): ?>
                    <?php for($i = 0; $i < $pagination->getLen(); $i++): ?>
                        <li class="page-item <?= $pagination->itemActive($i) ? "active": "" ?>">
                            <a class="page-link" href="<?= $pagination->setUrl($i) ?>">
                                <?= $pagination->getItemNumber($i) ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                <?php else: ?>
                    <?php for($i = 0; $i < $pagination->getMarker() + 2; $i++): ?>
                        <li class="page-item <?= $pagination->itemActive($i) ? "active": "" ?>">
                            <a class="page-link" href="<?= $pagination->setUrl($i) ?>">
                                <?= $pagination->getItemNumber($i) ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item <?= $pagination->itemActive($pagination->getLen() - 1) ? "active": "" ?>">
                        <a class="page-link" href="<?= $pagination->setUrl($pagination->getLen() - 1) ?>">
                            <?= $pagination->getItemNumber($pagination->getLen() - 1) ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <li class="page-item <?= $pagination->nextActive() ? "" : "disabled" ?>">
                <a class="page-link" href="<?= $pagination->next()?>">Next</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>