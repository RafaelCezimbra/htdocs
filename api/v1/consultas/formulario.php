<script>
    async function enviarFormulario(){
        const nome = document.getElementById("nome").value;
        let formData = new FormData();
        formData.append('nome', nome);

        await fetch('http://localhost:8888/php/api/v1/consultas/',{
         body: formData,
         method: 'POST'
        }).then((response) => alert(JSON.stringify(response)));
    }
</script>

<form>
    <input type="text" id="nome" name="nome" placeholder="nome"/>
    <button onclick="enviarFormulario()">Enviar</button>
</form>





