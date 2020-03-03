<!-- Main Table Ajax -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= print_var($contentTitle); ?></h3>
        <div id="main-table-buttons" class="card-tools">
        </div>
    </div>
    <div class="card-body">
        <table id="main-table" class="table table-striped table-bordered nowrap" style="width: 100%">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="main-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="main-modal-title"><?= print_var($contentTitle); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $attributes = array(
                    'id' => 'modal-form'
                );
                print_var(form_open('', $attributes));
                ?>
                <div id="modal-form-fields"></div>
                </form>
            </div>
            <div class="modal-footer">                
                <button id="main-modal-submit-button" type="button" class="btn btn-primary"></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-reply"></i> Batal</button>
            </div>

        </div>
    </div>
</div>