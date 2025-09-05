async function loadChartData(csvUrl) {
  try {
    const THRESHOLD = 140;

    const response = await fetch(csvUrl);
    const data = await response.text();

    // Split CSV data into rows and columns
    const rows = data.split('\n').map((row) => row.split(',').map((cell) => cell.trim()));
    if (rows.length < 2) {
      console.error('Invalid CSV format');
      return;
    }

    // Extract column headers dynamically
    const headers = rows[0].slice(1); // Ignore first column (assuming it's 'Quarter')
    const labels = rows.slice(1).map((row) => row[0]); // First column as labels (e.g., Q1, Q2)

    // Get the x-axis and y-axis labels
    const xLabel = jQuery('.chart-axis-legends .x-axis-title').text();
    const yLabel = jQuery('.chart-axis-legends .y-axis-title').text();

    // Extract dataset values dynamically
    const datasets = headers.map((header, index) => ({
      label: header,
      data: rows.slice(1).map((row) => {
        let value = parseFloat(row[index + 1]) || 0;
        return value === 0 ? THRESHOLD : value; // 0 denotes 'could not execute'.
      }),
      backgroundColor: header === 'Kinetica' ? '#0e7bf8' : '#585C60',
      diffs: [],
    }));

    /**
     * For storing datasets in the same format as the previous implementation.
     */
    const newDatasets = datasets.reduce((acc, item) => {
      const { label } = item;

      const foundKey = Object.keys(acc).find((key) => key === label);
      if (!foundKey) {
        acc[label.toLowerCase()] = item;
      }

      return acc;
    }, {});

    const chartAxis = document.getElementById('horizontal-chart-axis').getContext('2d');
    const horizontalChart = document.getElementById('horizontal-chart').getContext('2d');

    let benchmarkChartHorizontal = new Chart(horizontalChart, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [datasets[0], datasets[1]],
        borderWidth: 0,
      },
      options: {
        categoryPercentage: 0.9,
        barPercentage: 1,
        barThickness: 4,
        maintainAspectRatio: false,
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            max: THRESHOLD,
            grid: {
              display: false,
              drawTicks: false,
              drawBorder: true,
              color: '#383c40',
            },
            ticks: {
              display: false,
            },
          },
          x: {
            grid: {
              display: false,
            },
            ticks: {
              font: {
                size: 10,
                weight: 200,
                family: "'DM Sans', 'sans-serif'",
              },
              color: '#ffffff',
              count: 10,
              maxRotation: 0,
            },
            title: {
              display: true,
              text: xLabel,
              color: '#ffffff',
              font: {
                weight: 300,
                size: 12,
                family: "'DM Sans', 'sans-serif'",
              },
              padding: {
                top: 14,
              },
            },
            border: {
              display: true,
              color: '#36393c',
            },
          },
        },
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            enabled: true,
            callbacks: {
              label: function (tooltipData) {
                const label = tooltipData.dataset.label.toString();
                const value = tooltipData.dataset.data[tooltipData.dataIndex];

                if (value === THRESHOLD) {
                  return `${label} could not execute`;
                }

                return `${label}: ${value}`;
              },
            },
          },
        },
      },
    });

    let yAxisChart = new Chart(chartAxis, {
      type: 'bar',
      data: {
        labels: [],
        datasets: [datasets[0]],
        borderWidth: 0,
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            top: 20,
            bottom: 28,
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            max: THRESHOLD,
            afterFit: (ctx) => {
              ctx.width = 60;
            },
            border: {
              display: true,
              color: '#36393c',
            },
            title: {
              display: true,
              text: yLabel,
              color: '#ffffff',
              font: {
                family: "'DM Sans', 'sans-serif'",
                size: 12,
              },
            },
            ticks: {
              color: '#B2B4B5',
              font: {
                size: 12,
              },
            },
          },
        },
        plugins: {
          legend: {
            display: false,
          },
        },
      },
    });

    const updateChart = function (chart, newDataset) {
      chart.data.datasets.pop();
      const foundDataset = datasets.find((dataset) => dataset.label.toLowerCase() === newDataset.toLowerCase());

      chart.data.datasets.push(foundDataset);
      chart.update();

      const newLabel = foundDataset.label;

      jQuery('.benchmark-title').text(foundDataset.h2);
      jQuery('.benchmark-title+.subtitle').html(foundDataset.subtitle);
      jQuery('.legend-item:nth-of-type(2) span').text(newLabel);
    };

    // Show the first heading on initial load
    jQuery(window).on('load', function () {
      jQuery('.benchmark-title').hide().first().show();
    });

    // Update the cart and toggle active status of the buttons
    jQuery('.toggleBtn--chart').on('click', function () {
      const val = jQuery(this).data('val');
      const index = jQuery('.toggleBtn--chart').index(this);

      updateChart(benchmarkChartHorizontal, val);
      jQuery('.toggleBtn--chart').removeClass('active');
      jQuery(this).addClass('active');

      // Hide all the benchmark elements, then show the corresponding one
      jQuery('.benchmark-title').hide().eq(index).show();
    });

    /**
     * For making the colourful table when the table flag is set to true.
     * The entirety of this code beyond the guard clause has been copied from the original code
     * written in the Elementor HTML
     */
    function constructTable() {
      const table = jQuery('#tab-results');

      if (table.length === 0) {
        return;
      }

      let output = '';

      // To colour code the table, we rebuild the newDatasets matrix to figure how much difference there is
      // from the fastest result.

      // In order to color code the table, we need to rebuild the results matrix to figure out how
      // much differentiation there is from the fastest result.
      for (let i = 0; i < 99; i++) {
        // This iterates through the data for each project
        let col = [];
        colObj = [];
        for (const [key, value] of Object.entries(newDatasets)) {
          // This should push four values into our keys array.
          if (newDatasets[key].data[i] === 0) {
            col.push(9999);
          } else {
            col.push(newDatasets[key].data[i]);
          }
        }
        // Now we have an array of values for this query.
        let lowest_val = Math.min(...col);

        // Now let's loop again and calculate the diffs.
        for (const [key, value] of Object.entries(newDatasets)) {
          // This should push four values into our keys array.
          const diff = Math.round(newDatasets[key].data[i] / lowest_val);
          // console.log(newDatasets[key].label + ' Q' + i + ' is ' + newDatasets[key].data[i] + ': (' + diff + 'x slower)');
          newDatasets[key]['diffs'].push(diff);
        }
      }

      // Ok now we can output the tables.....
      let count = 1;
      let divider = 4;
      while (count <= divider) {
        let max = Math.round((count / divider) * 100) + 1;
        if (max > 100) {
          max = 100;
        }

        output += "<table class='results-table'><thead><tr><th class='db_name'></th>";

        // Loop through the headers....
        for (let i = max - Math.round(100 / divider); i < max; i++) {
          output += '<th>Q' + i + '</th>';
        }

        output += '</tr></thead><tbody>';

        for (const [key, value] of Object.entries(newDatasets)) {
          output += `<tr class='db ${key}'><th class='db_name' style='background-color:${newDatasets[key].backgroundColor}55; '>${newDatasets[key].label}</th>`;

          for (let i = max - Math.round(100 / divider) - 1; i < max - 1; i++) {
            let css = 'dark';
            if (newDatasets[key].data[i] === 0) {
              css = 'grey';
            } else {
              if (newDatasets[key].diffs[i] < 2 || newDatasets[key].data[i] < 1.5) {
                css = 'green';
              } else if (newDatasets[key].diffs[i] < 8) {
                css = 'yellow';
              } else if (newDatasets[key].diffs[i] < 20) {
                css = 'red';
              }
            }
            let val = Math.round(newDatasets[key].data[i] * 10) / 10;
            if (val === 0) {
              val = '-';
            }
            if (val > 100) {
              val = Math.round(val);
            }
            output += `<td class='${css}'>${val}</td>`;
          }
          output += '</tr>';
        }
        output += '</tbody></table>';

        count++;
      }

      document.getElementById('tab-results').innerHTML = output;
    }

    constructTable();
  } catch (error) {
    console.error('Error loading CSV data:', error);
  }
}

// Prevent vite's tree-shaking from removing the function
window.loadChartData = loadChartData;
