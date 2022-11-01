<?= $this->extend('default') ?>
<?= $this->section('content') ?>

<section class="mt-2">
    <?php
    $ano = date("Y");
    $mes = date("m");

    ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script type="text/javascript">
    function pdf() {
        var doc = new jsPDF();
        doc.setFontSize(25)
        doc.text(85, 10, "Relatorio")
        doc.setFontSize(14)
        doc.text(10, 30, "Id")
        doc.text(25, 30, "data")
        doc.text(80, 30, "descrição")
        doc.text(160, 30, "valor")
        doc.text(190, 30, "tipo")
        <?php
        $data = $this->data;
        $numero = 40;
        foreach ($data['moviments'] as $moviment) {
            echo 'doc.text(10, ' . $numero . ', "' . $moviment['id'] . '")
            ';
            echo 'doc.text(22, ' . $numero . ', "' . $moviment['date'] . '")
            ';
            echo 'doc.text(75, ' . $numero . ', "' . $moviment['description'] . '")
            ';
            echo 'doc.text(157, ' . $numero . ', "R$ ' . $moviment['value'] . '")
            ';
            echo 'doc.text(185, ' . $numero . ', "' . $moviment['type'] . '")
            ';
            $numero += 7;
        }
        echo 'doc.text(80, 275, "Saldo: R$ ' . $data['cash_balance'] . '")
        ';
        ?>
        doc.save('relatorio.pdf');


    }
</script>
<style>
    #btn-dark{
        background-color: #5C5A54;
    }
</style>
    <form method="post" action="<?= base_url('moviments/filtrar') ?>">
        <div id="header-moviment">
            <div class="input-group">
                <label class="input-group-text" for="inputGroupSelect01">Year</label>
                <select class="form-select" id="inputGroupSelect01" name="ano">
                    <?php
                    echo "<option value='$ano' selected>$ano</option>";
                    $ano = $ano - 1;
                    echo "<option value='$ano' >$ano</option>";
                    $ano = $ano - 1;
                    echo "<option value='$ano' >$ano</option>";
                    $ano = $ano - 1;
                    echo "<option value='$ano' >$ano</option>";
                    ?>

                </select>
            </div>
            <div class="input-group">
                <label class="input-group-text" for="inputGroupSelect01">Month</label>
                <select class="form-select" id="inputGroupSelect01" name="mes">
                    <?php
                    echo "<option value='$mes'>Mes</option>";
                    ?>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
            </div>
            <button class="btn btn-dark" id="btn-dark"> Filtrar </button>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">Cash balance</span>
                <input type="text" class="form-control" id="input-cash-balance" value="R$<?php echo $this->data['cash_balance']; ?>" disabled>
            </div>
        </div>
    </form>


    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Data</th>
                <th scope="col">Descrição</th>
                <th scope="col">Valor</th>
                <th scope="col">Input</th>
                <th scope="col">Output</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($this->data['moviments'] as $moviment) {

                echo "<tr>
        <td>{$moviment['id']}</td>
        <td>{$moviment['date']}</td>
        <td>{$moviment['description']}</td>
        <td>{$moviment['value']}</td>";
                if ($moviment['type'] == "input") {
                    echo "<td>*</td><td> - </td>";
                } else {
                    echo "<td> - </td><td> * </td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
        <table>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <a type="button" class="btn btn-dark p-3 fs-6" id="btn-dark" onclick="pdf()">Emitir relatório</a>
                    </div>
                </div>
            </div>
</section>

<?= $this->endSection() ?>