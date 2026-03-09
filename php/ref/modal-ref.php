 <?php include "ref_functions.php"; ?>
<div class="modal modal-refinfo text-primary" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-tables" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-light" align="center">Network info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php referrals_info(); ?>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-primary concluir-saque">Request</button>-->
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
      </div>
    </div>
  </div>
</div>