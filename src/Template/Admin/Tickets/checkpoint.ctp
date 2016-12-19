<div class="row">
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading">
                <h3>Tickets validés</h3>
            </div>
            <div class="panel-body">
                <h2 id="tickets-validated-count" style="margin: 0;">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading">
                <h3>Tickets PayPal</h3>
            </div>
            <div class="panel-body">
                <h2 id="tickets-paypal-count" style="margin: 0;">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading">
                <h3>Tickets permanence</h3>
            </div>
            <div class="panel-body">
                <h2 id="tickets-perm-count" style="margin: 0;">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading">
                <h3>Tickets sur place <button class="btn btn-info add-here">+1</button></h3>
            </div>
            <div class="panel-body">
                <h2 id="tickets-here-count" style="margin: 0;">0</h2>
            </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3>Tickets</h3>
    </div>

    <div class="panel-body">
        <table class="table table-striped table-bordered table-hover dataTable"></table>
    </div>
</div>

<?= $this->element('js/tickets.checkpoint'); ?>