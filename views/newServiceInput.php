<div class="collapse <?= !empty($res) ? 'show' : '' ?><?= !empty($showCollapse) ? ' show' : ''?>" id="newServiceInput">

    <div class="container">

        <!--Form with header-->
        <div class="container mt-2 mb-5">
            <div class="card">
                <div class="card-block px-4 py-3">


                    <div class="mt-1 mb-2 text-center">
                        <?= !empty($title['first']) ?
                            '<h3 class="mb-2">' . $title['first'] . '</h3><h5 class="mb-3">' . $title['second'] . '</h5>' :
                            '<h4 class="mb-3">' . $title . '</h4>'
                        ?>
                        <?= !empty($res) ? $res : ''; ?>
                    </div>

                    <!--Body-->
                    <form action="<?= base_url($action) ?>" method="post">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form">
                                    <input value="<?= set_value('nome') ?>" type="text" id="nome" name="nome" placeholder="Nome"
                                           class="form-control">
                                    <!--                            <label for="name">Nome</label>-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form">
                                    <input value="<?= set_value('marca') ?>" type="text" placeholder="Marca"
                                           id="marca" name="marca" class="form-control">
                                    <!--                            <label for="name">Nome</label>-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <input value="<?= set_value('observacao') ?>" type="text" placeholder="Observação"
                                           id="observacao" name="observacao" class="form-control">
                                    <!--                            <label for="name">Nome</label>-->
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <button class="btn btn-dlgreen">Enviar</button>
                        </div>
                </div>

                </form>

            </div>
        </div>
    </div>

</div>