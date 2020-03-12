<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Ссылка</th>
                        <th scope="col">Бюджет</th>
                        <th scope="col">Имя заказчика</th>
                        <th scope="col">Логин заказчика</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for project in projects %}
                    <tr>
                        <th><a href="{{ project.link }}">Ссылка</a></th>
                        <td>{{ project.amount }}</td>
                        <td>{{ project.name }}</td>
                        <td>{{ project.login }}</td>
                    </tr>
                    {% else %}

                    {% endfor %}
                    </tbody>
                </table>
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item {% if page is same as(1) %} disabled {% endif %}">
                            <a class="page-link" href="?page={{ page - 1 }}">Предыдущая</a>
                        </li>
                        <li class="page-item {% if page == totalPage %} disabled {% endif %}">
                            <a class="page-link" href="?page={{ page + 1 }}">Следующая</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Категория</th>
                        <th scope="col">Количество проектов</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for skill in skills %}
                    <tr>
                        <th scope="row">{{ skill.name }}</th>
                        <td>{{ skill.count }}</td>
                    </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6">
                <div id="container"></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        var pie = '{{ piechart }}';
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Количество задач в разрезе бюджета'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Бюджет',
                colorByPoint: true,
                data: JSON.parse(pie.replace(/&quot;/g,'"'))
            }]
        });
    </script>
</body>
</html>


