<link rel="stylesheet" href="../suprimentos/css/modal-estoque.css">
<script src="../suprimentos/js/modal-estoque.js" defer></script>

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
                    <select id="tipo" name="type">
                        <option value="">Selecione...</option>
                        <option value="E">Entrada</option>
                        <option value="S">Saída</option>
                        <option value="B">Balanço</option>
                    </select>
                </div>
                <div class="session-label-inpt">
                    <label>Custo do lançamento</label>
                    <input type="text" id="custo-lcto" name="cost">
                </div>
            </div>
            <div id="second-session">
                <div class="session-label-inpt">
                    <label>Quantidade</label>
                    <input type="text" id="quantidade" name="quantity">
                </div>
                <div class="session-label-inpt">
                    <label>Preço unitário</label>
                    <input type="text" id="price" name="price-un">
                </div>
            </div>
            <div id="div-btn-lcto">
                <button id="btn-lcto-estoque" onclick="lancarEstoque(event)">Lançar</button>
            </div>
        </form>
    </div>
</div>