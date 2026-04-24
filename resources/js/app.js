import './bootstrap';
import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById('graficoFluxo');

    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai'],
                datasets: [
                    {
                        label: 'Receitas',
                        data: [12000, 15000, 18000, 14000, 20000],
                        borderColor: '#10b981'
                    },
                    {
                        label: 'Despesas',
                        data: [8000, 9000, 11000, 9500, 12000],
                        borderColor: '#ef4444'
                    }
                ]
            }
        });
    }

});