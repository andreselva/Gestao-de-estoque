<link rel="stylesheet" href="../css/modal-estoque.css">
<script src="../js/modal-estoque.js" defer></script>

<div id="fade" class="hide"></div>
<div id="modal" class="hide">
    <div class="modal-header">
        <button id="close-modal">X</button>
        <h2>Incluir lançamento</h2>
    </div>
    <div class="modal-body">
        <form id="lcto-estoque" class="form-lcto">
            <div id="one-session">
                <div class="session-label-inpt">
                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo">
                        <option value="">Selecione...</option>
                        <option value="entrada">Entrada</option>
                        <option value="saida">Saída</option>
                    </select>
                </div>
                <div class="session-label-inpt">
                    <label>Custo do lançamento</label>
                    <input type="text" id="custo-lcto" name="custo-lcto">
                </div>
            </div>
            <div id="second-session">
                <div class="session-label-inpt">
                    <label>Quantidade</label>
                    <input type="text" id="quantidade" name="quantidade">
                </div>
            </div>
            <div id="div-btn-lcto">
                <button id="btn-lcto-estoque" onclick="lancarEstoque(event)">Lançar</button>
            </div>
        </form>
    </div>
</div>