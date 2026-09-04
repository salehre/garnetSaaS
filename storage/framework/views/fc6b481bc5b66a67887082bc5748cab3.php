<?php $__env->startSection('title', 'نمودار قیمت - ' . $customer->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin-top:0;">نمودار قیمت‌های <?php echo e($customer->name); ?>

            </h3>
            <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" class="btn btn-secondary">بازگشت</a>
        </div>

        <?php if($currencies->isEmpty()): ?>
            <p style="color:#6b7280;">این مشتری هنوز هیچ ارزی بهش اختصاص داده نشده.</p>
        <?php else: ?>
            <div style="display:flex; gap:16px; align-items:center; flex-wrap:wrap; margin-bottom:16px;">
                <div>
                    <label for="currency-select" style="display:block; font-size:13px; margin-bottom:4px;">ارز</label>
                    <select id="currency-select">
                        <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($currency->id); ?>"><?php echo e($currency->label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:13px; margin-bottom:4px;">بازه</label>
                    <div id="period-buttons" style="display:flex; gap:6px; flex-wrap:wrap;">
                        <button type="button" class="btn btn-secondary period-btn" data-period="24h">۲۴ ساعت اخیر</button>
                        <button type="button" class="btn btn-secondary period-btn" data-period="week">۱ هفته اخیر</button>
                        <button type="button" class="btn btn-secondary period-btn" data-period="month">۱ ماه اخیر</button>
                        <button type="button" class="btn btn-secondary period-btn" data-period="3month">۳ ماه اخیر</button>
                        <button type="button" class="btn btn-secondary period-btn" data-period="6month">۶ ماه اخیر</button>
                    </div>
                </div>
            </div>

            <canvas id="price-chart" height="110"></canvas>
        <?php endif; ?>
    </div>

    <style>
        .period-btn.active-period {
            outline: 2px solid #2563eb;
            outline-offset: -2px;
        }
    </style>

    <script src="<?php echo e(asset('vendor/chartjs/chart.umd.js')); ?>"></script>
    <script>
        (function () {
            const dataUrl = "<?php echo e(route('admin.customers.chart-data', $customer)); ?>";
            const currencySelect = document.getElementById('currency-select');
            const periodButtons = document.querySelectorAll('.period-btn');

            if (!currencySelect || periodButtons.length === 0) {
                return; // no currencies assigned — nothing to render
            }

            let currentPeriod = '24h';
            let chart = null;

            const COLORS = {
                price: '#2563eb',
                entry: '#6b7280',
                exit: '#2563eb',
                min: '#dc2626',
                max: '#16a34a',
                avg: '#a855f7',
            };

            const LABELS = {
                price: 'قیمت',
                entry: 'ورودی',
                exit: 'خروجی',
                min: 'کمترین',
                max: 'بیشترین',
                avg: 'میانگین',
            };

            async function loadChart() {
                const currencyId = currencySelect.value;
                const res = await fetch(`${dataUrl}?currency_id=${currencyId}&period=${currentPeriod}`);
                const json = await res.json();

                const labels = json.points.map(p => p.label);
                let datasets = [];

                if (json.type === 'raw') {
                    datasets.push({
                        label: LABELS.price,
                        data: json.points.map(p => p.price),
                        borderColor: COLORS.price,
                        fill: false,
                        tension: 0.2,
                        pointRadius: 0,
                    });
                } else {
                    ['entry', 'exit', 'min', 'max', 'avg'].forEach(key => {
                        datasets.push({
                            label: LABELS[key],
                            data: json.points.map(p => p[key]),
                            borderColor: COLORS[key],
                            fill: false,
                            tension: 0.2,
                            pointRadius: 0,
                        });
                    });
                }

                if (chart) {
                    chart.data.labels = labels;
                    chart.data.datasets = datasets;
                    chart.update();
                } else {
                    const ctx = document.getElementById('price-chart').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'line',
                        data: { labels, datasets },
                        options: {
                            responsive: true,
                            interaction: { mode: 'index', intersect: false },
                            scales: {
                                x: { ticks: { maxRotation: 60, minRotation: 30 } },
                            },
                        },
                    });
                }
            }

            periodButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    currentPeriod = btn.dataset.period;
                    periodButtons.forEach(b => b.classList.remove('active-period'));
                    btn.classList.add('active-period');
                    loadChart();
                });
            });

            currencySelect.addEventListener('change', loadChart);

            periodButtons[0].classList.add('active-period');
            loadChart();
        })();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projects\garnetSaaS\resources\views/admin/customers/chart.blade.php ENDPATH**/ ?>