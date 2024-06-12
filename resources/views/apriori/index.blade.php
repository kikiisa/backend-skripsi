@extends('layouts.master', [
    'judul' => 'Perhitungan Apriori',
])
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">Hasil Perhitungan Apriori</div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>antecedent</th>
                            <th>confidence</th>
                            <th>consequent</th>
                        </tr>
                    </thead>
                    <tbody class="datas">

                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="{{ asset('template/assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('template/assets/js/axios.min.js') }}"></script>
    <script>
        const table = document.querySelector(".datas");
        const card = document.querySelector(".card");
        async function resultApriori() {
            let html = ""
            try {
                const response = await axios.get("http://localhost:8000/api/algoritma-apriori")
                const datas = response.data.association_rules;
                if (datas.length == 0 || datas == null) {
                    card.innerHTML = `<button class="btn btn-primary" type="button" disabled>
  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
  <span class="visually-hidden" role="status">Loading...</span>
</button>
<button class="btn btn-primary" type="button" disabled>
  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
  <span role="status">Loading...</span>
</button>`

                }else{
                    datas.map((data, index) => {
                        let antecedentHTML = ""
                        let consequentHTML = "";
                        if (Array.isArray(data.consequent)) {
                            consequentHTML = data.consequent.map(item => `<span class="badge bg-primary">${item}</span>`).join(', ');
                        } else {
                            consequentHTML = `<span class="badge bg-primary">${data.consequent}</span>`;
                        }

                        if(Array.isArray(data.antecedent)){
                            antecedentHTML = data.antecedent.map(item => `<span class="badge bg-primary">${item}</span>`).join(', ');
                        }else{
                            antecedentHTML = `<span class="badge bg-primary">${data.antecedent}</span>`
                        }
                        html += `
                            <tr>
                                <th>${index+=1}</th>
                                <th>${antecedentHTML}</th>
                                <td>${data.confidence}</td>
                                <td>${consequentHTML}</td>
                            </tr>
                        `
                        console.log({
                            "confidence": data.confidence,
                            "antecedent": data.antecedent.length,
                            "consequent": data.consequent.length
                        });
                    })
                    table.innerHTML = html
                }

            } catch (error) {
                console.log(error);
                card.innerHTML = `
                        <div class="row justify-content-center mt-4 py-3">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                            Sementara Fecth Data
                        </div>`
            }
        }

        resultApriori()
    </script>
@endsection
