<div class="modal" tabindex="-1" id="menu_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h2> <?=$text_form?> </h2>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="
                    <?=$action?>">
                    <p>
                        <label for="edit-menu-title">Title</label>
                        <input type="text" name="title" id="edit-menu-title" value="
                            <?php echo $title; ?>">
                    </p>
                    <p>
                        <label for="edit-menu-url">URL</label>
                        <input type="text" name="url" id="edit-menu-url" value="
                                <?php echo $url; ?>">
                    </p>
                    <p>
                        <label for="edit-menu-class">Class</label>
                        <input type="text" name="class" id="edit-menu-class" value="
                                    <?php echo $class; ?>">
                    </p>
                    <p>
                        <label for="edit-menu-class">Icon Class</label>
                        <input type="text" name="iconmenu" id="edit-menu-class" value="
                                        <?php echo $iconmenu; ?>">
                    </p>
                    <p>
                        <label>
                            <input name="target" type="checkbox" value="1" <?php if($target == 1){ echo 'checked' ; }?> style="margin-right: 10px;vertical-align: bottom;">Check for Open in a new windwow </label>
                    </p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>