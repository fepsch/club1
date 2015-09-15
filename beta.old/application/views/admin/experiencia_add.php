<fieldset>
    <div class="row">
        <div class="small-6 column">
            <?php echo validation_errors(); ?>
            <?php if ($this->router->method == 'add'): ?>
                <legend>AGREGAR NUEVA EXPERIENCIA</legend>
            <?php else: ?>
                <legend>EDITAR EXPERIENCIA</legend>
            <?php endif; ?>
        </div>
    </div>
    <div class="form">
        <?php echo form_open_multipart(); ?>
        <input type='hidden' name='chef' value='<?= $idChef ?>' />
        <div class="row">
            <div class="small-12 medium-6 large-6 column">
                <label>Nombre
                    <input class="" type="text" name="nombre" value="<?= set_value('nombre', (isset($experiencia['nombre']) ? $experiencia['nombre'] : '')) ?>"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-6 large-6 column">
                <label>Descripción
                    <textarea name="descripcion" ><?= set_value('descripcion', (isset($experiencia['descripcion']) ? $experiencia['descripcion'] : '')) ?></textarea>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-6 large-6 column">
                <label>Duración por cantidad de personas(horas)</label>
                <h5><small>*Debe utilizar símbolo punto "." para separar décimas</small></h5>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-6 column">
                <ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-3">
                    <!-- 2 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo2" class="prefix">2 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo2" name='tiempo2' value="<?= set_value('tiempo2', (isset($experiencia['tiempo2']) ? $experiencia['tiempo2'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 3 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo3" class="prefix">3 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo3" name='tiempo3' value="<?= set_value('tiempo3', (isset($experiencia['tiempo3']) ? $experiencia['tiempo3'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 4 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo4" class="prefix">4 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo4" name='tiempo4' value="<?= set_value('tiempo4', (isset($experiencia['tiempo4']) ? $experiencia['tiempo4'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 5 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo5" class="prefix">5 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo5" name='tiempo5' value="<?= set_value('tiempo5', (isset($experiencia['tiempo5']) ? $experiencia['tiempo5'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 6 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo6" class="prefix">6 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo6" name='tiempo6' value="<?= set_value('tiempo6', (isset($experiencia['tiempo6']) ? $experiencia['tiempo6'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 7 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo7" class="prefix">7 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo7" name='tiempo7' value="<?= set_value('tiempo7', (isset($experiencia['tiempo7']) ? $experiencia['tiempo7'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 8 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo8" class="prefix">8 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo8" name='tiempo8' value="<?= set_value('tiempo8', (isset($experiencia['tiempo8']) ? $experiencia['tiempo8'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 9 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo9" class="prefix">9 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo9" name='tiempo9' value="<?= set_value('tiempo9', (isset($experiencia['tiempo9']) ? $experiencia['tiempo9'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 10 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo10" class="prefix">10 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo10" name='tiempo10' value="<?= set_value('tiempo10', (isset($experiencia['tiempo10']) ? $experiencia['tiempo10'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 11 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo11" class="prefix">11 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo11" name='tiempo11' value="<?= set_value('tiempo11', (isset($experiencia['tiempo11']) ? $experiencia['tiempo11'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 12 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo12" class="prefix">12 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo12" name='tiempo12' value="<?= set_value('tiempo12', (isset($experiencia['tiempo12']) ? $experiencia['tiempo12'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 13 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo13" class="prefix">13 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo13" name='tiempo13' value="<?= set_value('tiempo13', (isset($experiencia['tiempo13']) ? $experiencia['tiempo13'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                    <!-- 14 personas -->
                    <li>
                        <div class="row collapse">
                            <div class="small-5 column">
                                <span for="tiempo14" class="prefix">14 p.</span>
                            </div>
                            <div class="small-7 column">
                                <input type='text' id="tiempo14" name='tiempo14' value="<?= set_value('tiempo14', (isset($experiencia['tiempo14']) ? $experiencia['tiempo14'] : '')); ?>"/>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="small-6 column">
            <label>Imagen (622x200px | gif, png, jpg)
                <input type="file" name="imagen"/>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-6 small-centered column">
            <input class="button" type='submit' value='Guardar' />
        </div>
    </div>
    <div>
        <?= isset($error) ? $error : '' ?>
    </div>
    <?php echo form_close(); ?>
</div>
</fieldset>