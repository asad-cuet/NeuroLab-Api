// ********************* Colum chart start here ***************** //

// const { error } = require("fancy-log");


// column chart 1 
const options = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'sales',
    data: [30, 40, 45, 50, 49, 60, 70, 91]
  }],
  xaxis: {
    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
  }
}


const columnSelector1 = document.querySelector("#columnChart1");

// console.log(columnSelector1)

if (columnSelector1) {
  const columnChart1 = new ApexCharts(columnSelector1, options);
  columnChart1.render();
}



// column chart 2
const options2 = {
  series: [{
    name: 'Net Profit',
    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
  }, {
    name: 'Revenue',
    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
  }, {
    name: 'Free Cash Flow',
    data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
  }],
  chart: {
    type: 'bar'
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%',
      endingShape: 'rounded'
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  xaxis: {
    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
  },
  yaxis: {
    title: {
      text: '$ (thousands)'
    }
  },
  fill: {
    opacity: 1
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return "$ " + val + " thousands"
      }
    }
  }
};

const columnSelector2 = document.querySelector("#columnChart2");
if (columnSelector2) {
  const columnChart2 = new ApexCharts(columnSelector2, options2);
  columnChart2.render();
}



// column chart 3
const options3 = {
  series: [{
    name: 'Q1 Budget',
    group: 'budget',
    data: [44000, 55000, 41000, 67000, 22000, 43000]
  },
  {
    name: 'Q1 Actual',
    group: 'actual',
    data: [48000, 50000, 40000, 65000, 25000, 40000]
  },
  {
    name: 'Q2 Budget',
    group: 'budget',
    data: [13000, 36000, 20000, 8000, 13000, 27000]
  },
  {
    name: 'Q2 Actual',
    group: 'actual',
    data: [20000, 40000, 25000, 10000, 12000, 28000]
  }
  ],
  chart: {
    type: 'bar',
    height: 350,
    stacked: true,
  },
  stroke: {
    width: 1,
    colors: ['#fff']
  },
  dataLabels: {
    formatter: (val) => {
      return val / 1000 + 'K'
    }
  },
  plotOptions: {
    bar: {
      horizontal: false
    }
  },
  xaxis: {
    categories: [
      'Online advertising',
      'Sales Training',
      'Print advertising',
      'Catalogs',
      'Meetings',
      'Public relations'
    ]
  },
  fill: {
    opacity: 1
  },
  colors: ['#80c7fd', '#008FFB', '#80f1cb', '#00E396'],
  yaxis: {
    labels: {
      formatter: (val) => {
        return val / 1000 + 'K'
      }
    }
  },
  legend: {
    position: 'top',
    horizontalAlign: 'left'
  }
};


const columnSelector3 = document.querySelector("#columnChart3");
if (columnSelector3) {
  const columnChart3 = new ApexCharts(columnSelector3, options3);
  columnChart3.render();
}







// column chart 4
const options4 = {
  series: [{
    data: [{
      x: '2008',
      y: [2800, 4500]
    },
    {
      x: '2009',
      y: [3200, 4100]
    },
    {
      x: '2010',
      y: [2950, 7800]
    },
    {
      x: '2011',
      y: [3000, 4600]
    },
    {
      x: '2012',
      y: [3500, 4100]
    },
    {
      x: '2013',
      y: [4500, 6500]
    },
    {
      x: '2014',
      y: [4100, 5600]
    }
    ]
  }],
  chart: {
    height: 350,
    type: 'rangeBar',
    zoom: {
      enabled: false
    }
  },
  plotOptions: {
    bar: {
      isDumbbell: true,
      columnWidth: 3,
      dumbbellColors: [
        ['#008FFB', '#00E396']
      ]
    }
  },
  legend: {
    show: true,
    showForSingleSeries: true,
    position: 'top',
    horizontalAlign: 'left',
    customLegendItems: ['Product A', 'Product B']
  },
  fill: {
    type: 'gradient',
    gradient: {
      type: 'vertical',
      gradientToColors: ['#00E396'],
      inverseColors: true,
      stops: [0, 100]
    }
  },
  grid: {
    xaxis: {
      lines: {
        show: true
      }
    },
    yaxis: {
      lines: {
        show: false
      }
    }
  },
  xaxis: {
    tickPlacement: 'on'
  }
};

const columnSelector4 = document.querySelector("#columnChart4");
if (columnSelector3) {
  const columnChart4 = new ApexCharts(columnSelector4, options4);
  columnChart4.render();

}


// column chart 5
const options5 = {
  series: [{
    name: 'Inflation',
    data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
  }],
  chart: {
    height: 350,
    type: 'bar',
  },
  plotOptions: {
    bar: {
      dataLabels: {
        position: 'top', // top, center, bottom
      },
    }
  },
  dataLabels: {
    enabled: true,
    formatter: function (val) {
      return val + "%";
    },
    offsetY: -20,
    style: {
      fontSize: '12px',
      colors: ["#304758"]
    }
  },

  xaxis: {
    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    position: 'top',
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    },
    crosshairs: {
      fill: {
        type: 'gradient',
        gradient: {
          colorFrom: '#D8E3F0',
          colorTo: '#BED1E6',
          stops: [0, 100],
          opacityFrom: 0.4,
          opacityTo: 0.5,
        }
      }
    },
    tooltip: {
      enabled: true,
    }
  },
  yaxis: {
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false,
    },
    labels: {
      show: false,
      formatter: function (val) {
        return val + "%";
      }
    }

  },
  title: {
    text: 'Monthly Inflation in Argentina, 2002',
    floating: true,
    offsetY: 330,
    align: 'center',
    style: {
      color: '#444'
    }
  }
};


const columnSelector5 = document.querySelector("#columnChart5");
if (columnSelector5) {
  const columnChart5 = new ApexCharts(columnSelector5, options5);
  columnChart5.render();

}


// column chart 5
const options6 = {
  series: [{
    name: 'PRODUCT A',
    data: [44, 55, 41, 67, 22, 43]
  }, {
    name: 'PRODUCT B',
    data: [13, 23, 20, 8, 13, 27]
  }, {
    name: 'PRODUCT C',
    data: [11, 17, 15, 15, 21, 14]
  }, {
    name: 'PRODUCT D',
    data: [21, 7, 25, 13, 22, 8]
  }],
  chart: {
    type: 'bar',
    height: 350,
    stacked: true,
    toolbar: {
      show: true
    },
    zoom: {
      enabled: true
    }
  },
  responsive: [{
    breakpoint: 480,
    options: {
      legend: {
        position: 'bottom',
        offsetX: -10,
        offsetY: 0
      }
    }
  }],
  plotOptions: {
    bar: {
      horizontal: false,
      borderRadius: 10,
      dataLabels: {
        total: {
          enabled: true,
          style: {
            fontSize: '13px',
            fontWeight: 900
          }
        }
      }
    },
  },
  xaxis: {
    type: 'datetime',
    categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT',
      '01/05/2011 GMT', '01/06/2011 GMT'
    ],
  },
  legend: {
    position: 'right',
    offsetY: 40
  },
  fill: {
    opacity: 1
  }
};


const columnSelector6 = document.querySelector("#columnChart6");
if (columnSelector6) {
  const columnChart6 = new ApexCharts(columnSelector6, options6);
  columnChart6.render();

}




// ********************* Colum chart end here ***************** //




// ********************* Line chart start here ***************** //

// line chart 1 -- basic line chart


const line1 = {
  series: [{
    name: "Desktops",
    data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
  }],
  chart: {
    height: 350,
    type: 'line',
    zoom: {
      enabled: false
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'straight'
  },
  title: {
    text: 'Product Trends by Month',
    align: 'left'
  },
  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    },
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
  }
};


const lineSelector1 = document.querySelector("#lineChart1");
if (lineSelector1) {
  const lineChart1 = new ApexCharts(lineSelector1, line1);
  lineChart1.render();
}




// line chart 2  ---  Line with Data Labels

const line2 = {
  series: [{
    name: "High - 2013",
    data: [28, 29, 33, 36, 32, 32, 33]
  },
  {
    name: "Low - 2013",
    data: [12, 11, 14, 18, 17, 13, 13]
  }
  ],
  chart: {
    height: 350,
    type: 'line',
    dropShadow: {
      enabled: true,
      color: '#000',
      top: 18,
      left: 7,
      blur: 10,
      opacity: 0.2
    },
    toolbar: {
      show: false
    }
  },
  colors: ['#77B6EA', '#545454'],
  dataLabels: {
    enabled: true,
  },
  stroke: {
    curve: 'smooth'
  },
  title: {
    text: 'Average High & Low Temperature',
    align: 'left'
  },
  grid: {
    borderColor: '#e7e7e7',
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    },
  },
  markers: {
    size: 1
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    title: {
      text: 'Month'
    }
  },
  yaxis: {
    title: {
      text: 'Temperature'
    },
    min: 5,
    max: 40
  },
  legend: {
    position: 'top',
    horizontalAlign: 'right',
    floating: true,
    offsetY: -25,
    offsetX: -5
  }
};


const lineSelector2 = document.querySelector("#lineChart2");
if (lineSelector2) {
  const lineChart2 = new ApexCharts(lineSelector1, line2);
  lineChart2.render();
}



// line chart 3  ---  Dashed line chart
const line3 = {
  series: [{
    name: "Session Duration",
    data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
  },
  {
    name: "Page Views",
    data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
  },
  {
    name: 'Total Visits',
    data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
  }
  ],
  chart: {
    height: 350,
    type: 'line',
    zoom: {
      enabled: false
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: [5, 7, 5],
    curve: 'straight',
    dashArray: [0, 8, 5]
  },
  title: {
    text: 'Page Statistics',
    align: 'left'
  },
  legend: {
    tooltipHoverFormatter: function (val, opts) {
      return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
    }
  },
  markers: {
    size: 0,
    hover: {
      sizeOffset: 6
    }
  },
  xaxis: {
    categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
      '10 Jan', '11 Jan', '12 Jan'
    ],
  },
  tooltip: {
    y: [{
      title: {
        formatter: function (val) {
          return val + " (mins)"
        }
      }
    },
    {
      title: {
        formatter: function (val) {
          return val + " per session"
        }
      }
    },
    {
      title: {
        formatter: function (val) {
          return val;
        }
      }
    }
    ]
  },
  grid: {
    borderColor: '#f1f1f1',
  }
};


const lineSelector3 = document.querySelector("#lineChart3");
if (lineSelector3) {
  const lineChart3 = new ApexCharts(lineSelector1, line3);
  lineChart3.render();
}


// line chart 4  ---  Dashed line chart
const line4 = {
  series: [{
    name: 'Sales',
    data: [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13, 9, 17, 2, 7, 5]
  }],
  chart: {
    height: 350,
    type: 'line',
  },
  forecastDataPoints: {
    count: 7
  },
  stroke: {
    width: 5,
    curve: 'smooth'
  },
  xaxis: {
    type: 'datetime',
    categories: ['1/11/2000', '2/11/2000', '3/11/2000', '4/11/2000', '5/11/2000', '6/11/2000', '7/11/2000', '8/11/2000', '9/11/2000', '10/11/2000', '11/11/2000', '12/11/2000', '1/11/2001', '2/11/2001', '3/11/2001', '4/11/2001', '5/11/2001', '6/11/2001'],
    tickAmount: 10,
    labels: {
      formatter: function (value, timestamp, opts) {
        return opts.dateFormatter(new Date(timestamp), 'dd MMM')
      }
    }
  },
  title: {
    text: 'Forecast',
    align: 'left',
    style: {
      fontSize: "16px",
      color: '#666'
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'dark',
      gradientToColors: ['#FDD835'],
      shadeIntensity: 1,
      type: 'horizontal',
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 100, 100, 100]
    },
  },
  yaxis: {
    min: -10,
    max: 40
  }
};


const lineSelector4 = document.querySelector("#lineChart4");
if (lineSelector4) {
  const lineChart4 = new ApexCharts(lineSelector4, line4);
  lineChart4.render();
}

// line chart 5  ---  line award desgin
const line5 = {
  chart: {
    type: 'line',
    height: 350,
    id: 'line-adwords',
  },
  series: [{
    name: 'Sales',
    data: [30, 40, 35, 50, 49, 60, 70, 91]
  }],
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug']
  },
  title: {
    text: 'Adwords Performance'
  }
};

const lineSelector5 = document.querySelector("#line-adwords");

if (lineSelector5) {
  const linechart5 = new ApexCharts(lineSelector5, line5);
  linechart5.render();
}



// ********************* Line chart end here ***************** //


// ********************* Bar chart bar here ***************** //
// bar chart 1  ---  basic bar chart
const bar1 = {
  series: [{
    data: [400, 530, 248, 670]
  }],
  chart: {
    type: 'bar',
    height: 350
  },
  plotOptions: {
    bar: {
      borderRadius: 4,
      horizontal: true,
    }
  },
  dataLabels: {
    enabled: false
  },
  colors: ['#6D71FA', '#33b2df'],
  xaxis: {
    categories: ['cuet.ac.bd', 'job.cuet.ac.bd', 'library.cuet.ac.bd', 'alumni.cuet.ac.bd'
    ],
  }
};


const barSelector1 = document.querySelector("#barChart1");
if (barSelector1) {
  const barChart1 = new ApexCharts(barSelector1, bar1);
  barChart1.render();
}


// bar chart 2  ---  Stacked Bar chart
const bar2 = {
  series: [{
    name: 'Marine Sprite',
    data: [44, 55, 41, 37, 22, 43, 21]
  }, {
    name: 'Striking Calf',
    data: [53, 32, 33, 52, 13, 43, 32]
  }, {
    name: 'Tank Picture',
    data: [12, 17, 11, 9, 15, 11, 20]
  }, {
    name: 'Bucket Slope',
    data: [9, 7, 5, 8, 6, 9, 4]
  }, {
    name: 'Reborn Kid',
    data: [25, 12, 19, 32, 25, 24, 10]
  }],
  chart: {
    type: 'bar',
    height: 350,
    stacked: true,
  },
  plotOptions: {
    bar: {
      horizontal: true,
      dataLabels: {
        total: {
          enabled: true,
          offsetX: 0,
          style: {
            fontSize: '13px',
            fontWeight: 900
          }
        }
      }
    },
  },
  stroke: {
    width: 1,
    colors: ['#fff']
  },
  title: {
    text: 'Fiction Books Sales'
  },
  xaxis: {
    categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
    labels: {
      formatter: function (val) {
        return val + "K"
      }
    }
  },
  yaxis: {
    title: {
      text: undefined
    },
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + "K"
      }
    }
  },
  fill: {
    opacity: 1
  },
  legend: {
    position: 'top',
    horizontalAlign: 'left',
    offsetX: 40
  }
};


const barSelector2 = document.querySelector("#barChart2");
if (barSelector2) {
  const barChart2 = new ApexCharts(barSelector2, bar2);
  barChart2.render();
}



// bar chart 3  ---  Grouped Stacked Bars chart
const bar3 = {
  series: [{
    name: 'Q1 Budget',
    group: 'budget',
    data: [44000, 55000, 41000, 67000, 22000]
  },
  {
    name: 'Q1 Actual',
    group: 'actual',
    data: [48000, 50000, 40000, 65000, 25000]
  },
  {
    name: 'Q2 Budget',
    group: 'budget',
    data: [13000, 36000, 20000, 8000, 13000]
  },
  {
    name: 'Q2 Actual',
    group: 'actual',
    data: [20000, 40000, 25000, 10000, 12000]
  }
  ],
  chart: {
    type: 'bar',
    height: 350,
    stacked: true,
  },
  stroke: {
    width: 1,
    colors: ['#fff']
  },
  dataLabels: {
    formatter: (val) => {
      return val / 1000 + 'K'
    }
  },
  plotOptions: {
    bar: {
      horizontal: true
    }
  },
  xaxis: {
    categories: [
      'Online advertising',
      'Sales Training',
      'Print advertising',
      'Catalogs',
      'Meetings'
    ],
    labels: {
      formatter: (val) => {
        return val / 1000 + 'K'
      }
    }
  },
  fill: {
    opacity: 1,
  },
  colors: ['#80c7fd', '#008FFB', '#80f1cb', '#00E396'],
  legend: {
    position: 'top',
    horizontalAlign: 'left'
  }
};


const barSelector3 = document.querySelector("#barChart3");
if (barSelector3) {
  const barChart3 = new ApexCharts(barSelector3, bar3);
  barChart3.render();
}


// bar chart 4  ---  Grouped Stacked Bars chart
const bar4 = {
  series: [{
    data: [44, 55, 41, 64, 22, 43, 21]
  }, {
    data: [53, 32, 33, 52, 13, 44, 32]
  }],
  chart: {
    type: 'bar',
    height: 430
  },
  plotOptions: {
    bar: {
      horizontal: true,
      dataLabels: {
        position: 'top',
      },
    }
  },
  dataLabels: {
    enabled: true,
    offsetX: -6,
    style: {
      fontSize: '12px',
      colors: ['#fff']
    }
  },
  stroke: {
    show: true,
    width: 1,
    colors: ['#fff']
  },
  tooltip: {
    shared: true,
    intersect: false
  },
  xaxis: {
    categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
  },
};



const barSelector4 = document.querySelector("#barChart4");
if (barSelector4) {
  const barChart4 = new ApexCharts(barSelector4, bar4);
  barChart4.render();
}



// ********************* Bar chart end here ***************** //


// ********************* Area chart start here ***************** //

// area chart 1  ---  Spline line chart


const area1 = {
  chart: {
    type: 'area',
    height: 350,
    toolbar: {
      show: false
    },
    zoom: {
      enabled: false
    },
    animations: {
      enabled: true,
      easing: 'easeinout',
      speed: 800,
    }
  },
  stroke: {
    curve: 'smooth',
    width: 2,
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 1,
      gradientToColors: ['#6D71FA'],  // Ending color of the gradient
      inverseColors: false,
      opacityFrom: 0.8,
      opacityTo: 0.2,
      stops: [0, 100]
    },
    colors: ['#6D71FA'],  // Starting color of the gradient
  },
  dataLabels: {
    enabled: false
  },
  markers: {
    size: 5,
    colors: ['#fff'],
    strokeColors: '#5B65FF',
    strokeWidth: 3,
    hover: {
      size: 7,
    }
  },
  tooltip: {
    enabled: true,
    custom: function ({ series, seriesIndex, dataPointIndex, w }) {
      const data = series[seriesIndex][dataPointIndex];
      const date = w.globals.labels[dataPointIndex];
      return `
        <div style="background: white; border-radius: 8px; padding: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
          <div style="font-size: 12px; color: #888; margin-bottom: 4px;">${date}</div>
          <div class="d-flex align-items-center gap-2">
            <p style="font-size: 20px; font-weight: bold; color: #000;" line-height: 1; class="mb-0"> ${data.toLocaleString()}</p>
            <span class="badge bg-success">+3%</span>
          </div>
        </div>
      `;
    },
    style: {
      fontSize: '14px',
      // fontFamily: undefined
    },
    marker: {
      show: false
    }
  },
  series: [{
    name: 'Data',
    data: [30000, 45000, 35000, 60000, 90000, 80000, 70000, 100000, 75000, 50000, 40000]
  }],
  xaxis: {
    categories: ['Mar-25', 'Feb-25', 'Jan-25', 'Dec-24', 'Nov-24', 'Oct-24', 'Sept-24', 'Aug-24', 'July-24', 'Jun-24', 'May-24', 'Apr-24'],
    labels: {
      style: {
        colors: '#888',
        fontSize: '12px',
      }
    },
  },
  yaxis: {
    labels: {
      style: {
        colors: '#888',
        fontSize: '12px',
      },
      formatter: function (val) {
        return val >= 1000 ? (val / 1000) + 'K' : val;
      }
    }
  },
  grid: {
    borderColor: '#f1f1f1',
  }
};

const areaSelector1 = document.querySelector("#areaChart1");
if (areaSelector1) {
  const areaChart1 = new ApexCharts(areaSelector1, area1);
  areaChart1.render();
}



// area chart 2  ---  Datetime X-Axis line chart
var area2 = {
  series: [{
    data: [
      [1327359600000, 30.95],
      [1327446000000, 31.34],
      [1327532400000, 31.18],
      [1327618800000, 31.05],
      [1327878000000, 31.00],
      [1327964400000, 30.95],
      [1328050800000, 31.24],
      [1328137200000, 31.29],
      [1328223600000, 31.85],
      [1328482800000, 31.86],
      [1328569200000, 32.28],
      [1328655600000, 32.10],
      [1328742000000, 32.65],
      [1328828400000, 32.21],
      [1329087600000, 32.35],
      [1329174000000, 32.44],
      [1329260400000, 32.46],
      [1329346800000, 32.86],
      [1329433200000, 32.75],
      [1329778800000, 32.54],
      [1329865200000, 32.33],
      [1329951600000, 32.97],
      [1330038000000, 33.41],
      [1330297200000, 33.27],
      [1330383600000, 33.27],
      [1330470000000, 32.89],
      [1330556400000, 33.10],
      [1330642800000, 33.73],
      [1330902000000, 33.22],
      [1330988400000, 31.99],
      [1331074800000, 32.41],
      [1331161200000, 33.05],
      [1331247600000, 33.64],
      [1331506800000, 33.56],
      [1331593200000, 34.22],
      [1331679600000, 33.77],
      [1331766000000, 34.17],
      [1331852400000, 33.82],
      [1332111600000, 34.51],
      [1332198000000, 33.16],
      [1332284400000, 33.56],
      [1332370800000, 33.71],
      [1332457200000, 33.81],
      [1332712800000, 34.40],
      [1332799200000, 34.63],
      [1332885600000, 34.46],
      [1332972000000, 34.48],
      [1333058400000, 34.31],
      [1333317600000, 34.70],
      [1333404000000, 34.31],
      [1333490400000, 33.46],
      [1333576800000, 33.59],
      [1333922400000, 33.22],
      [1334008800000, 32.61],
      [1334095200000, 33.01],
      [1334181600000, 33.55],
      [1334268000000, 33.18],
      [1334527200000, 32.84],
      [1334613600000, 33.84],
      [1334700000000, 33.39],
      [1334786400000, 32.91],
      [1334872800000, 33.06],
      [1335132000000, 32.62],
      [1335218400000, 32.40],
      [1335304800000, 33.13],
      [1335391200000, 33.26],
      [1335477600000, 33.58],
      [1335736800000, 33.55],
      [1335823200000, 33.77],
      [1335909600000, 33.76],
      [1335996000000, 33.32],
      [1336082400000, 32.61],
      [1336341600000, 32.52],
      [1336428000000, 32.67],
      [1336514400000, 32.52],
      [1336600800000, 31.92],
      [1336687200000, 32.20],
      [1336946400000, 32.23],
      [1337032800000, 32.33],
      [1337119200000, 32.36],
      [1337205600000, 32.01],
      [1337292000000, 31.31],
      [1337551200000, 32.01],
      [1337637600000, 32.01],
      [1337724000000, 32.18],
      [1337810400000, 31.54],
      [1337896800000, 31.60],
      [1338242400000, 32.05],
      [1338328800000, 31.29],
      [1338415200000, 31.05],
      [1338501600000, 29.82],
      [1338760800000, 30.31],
      [1338847200000, 30.70],
      [1338933600000, 31.69],
      [1339020000000, 31.32],
      [1339106400000, 31.65],
      [1339365600000, 31.13],
      [1339452000000, 31.77],
      [1339538400000, 31.79],
      [1339624800000, 31.67],
      [1339711200000, 32.39],
      [1339970400000, 32.63],
      [1340056800000, 32.89],
      [1340143200000, 31.99],
      [1340229600000, 31.23],
      [1340316000000, 31.57],
      [1340575200000, 30.84],
      [1340661600000, 31.07],
      [1340748000000, 31.41],
      [1340834400000, 31.17],
      [1340920800000, 32.37],
      [1341180000000, 32.19],
      [1341266400000, 32.51],
      [1341439200000, 32.53],
      [1341525600000, 31.37],
      [1341784800000, 30.43],
      [1341871200000, 30.44],
      [1341957600000, 30.20],
      [1342044000000, 30.14],
      [1342130400000, 30.65],
      [1342389600000, 30.40],
      [1342476000000, 30.65],
      [1342562400000, 31.43],
      [1342648800000, 31.89],
      [1342735200000, 31.38],
      [1342994400000, 30.64],
      [1343080800000, 30.02],
      [1343167200000, 30.33],
      [1343253600000, 30.95],
      [1343340000000, 31.89],
      [1343599200000, 31.01],
      [1343685600000, 30.88],
      [1343772000000, 30.69],
      [1343858400000, 30.58],
      [1343944800000, 32.02],
      [1344204000000, 32.14],
      [1344290400000, 32.37],
      [1344376800000, 32.51],
      [1344463200000, 32.65],
      [1344549600000, 32.64],
      [1344808800000, 32.27],
      [1344895200000, 32.10],
      [1344981600000, 32.91],
      [1345068000000, 33.65],
      [1345154400000, 33.80],
      [1345413600000, 33.92],
      [1345500000000, 33.75],
      [1345586400000, 33.84],
      [1345672800000, 33.50],
      [1345759200000, 32.26],
      [1346018400000, 32.32],
      [1346104800000, 32.06],
      [1346191200000, 31.96],
      [1346277600000, 31.46],
      [1346364000000, 31.27],
      [1346709600000, 31.43],
      [1346796000000, 32.26],
      [1346882400000, 32.79],
      [1346968800000, 32.46],
      [1347228000000, 32.13],
      [1347314400000, 32.43],
      [1347400800000, 32.42],
      [1347487200000, 32.81],
      [1347573600000, 33.34],
      [1347832800000, 33.41],
      [1347919200000, 32.57],
      [1348005600000, 33.12],
      [1348092000000, 34.53],
      [1348178400000, 33.83],
      [1348437600000, 33.41],
      [1348524000000, 32.90],
      [1348610400000, 32.53],
      [1348696800000, 32.80],
      [1348783200000, 32.44],
      [1349042400000, 32.62],
      [1349128800000, 32.57],
      [1349215200000, 32.60],
      [1349301600000, 32.68],
      [1349388000000, 32.47],
      [1349647200000, 32.23],
      [1349733600000, 31.68],
      [1349820000000, 31.51],
      [1349906400000, 31.78],
      [1349992800000, 31.94],
      [1350252000000, 32.33],
      [1350338400000, 33.24],
      [1350424800000, 33.44],
      [1350511200000, 33.48],
      [1350597600000, 33.24],
      [1350856800000, 33.49],
      [1350943200000, 33.31],
      [1351029600000, 33.36],
      [1351116000000, 33.40],
      [1351202400000, 34.01],
      [1351638000000, 34.02],
      [1351724400000, 34.36],
      [1351810800000, 34.39],
      [1352070000000, 34.24],
      [1352156400000, 34.39],
      [1352242800000, 33.47],
      [1352329200000, 32.98],
      [1352415600000, 32.90],
      [1352674800000, 32.70],
      [1352761200000, 32.54],
      [1352847600000, 32.23],
      [1352934000000, 32.64],
      [1353020400000, 32.65],
      [1353279600000, 32.92],
      [1353366000000, 32.64],
      [1353452400000, 32.84],
      [1353625200000, 33.40],
      [1353884400000, 33.30],
      [1353970800000, 33.18],
      [1354057200000, 33.88],
      [1354143600000, 34.09],
      [1354230000000, 34.61],
      [1354489200000, 34.70],
      [1354575600000, 35.30],
      [1354662000000, 35.40],
      [1354748400000, 35.14],
      [1354834800000, 35.48],
      [1355094000000, 35.75],
      [1355180400000, 35.54],
      [1355266800000, 35.96],
      [1355353200000, 35.53],
      [1355439600000, 37.56],
      [1355698800000, 37.42],
      [1355785200000, 37.49],
      [1355871600000, 38.09],
      [1355958000000, 37.87],
      [1356044400000, 37.71],
      [1356303600000, 37.53],
      [1356476400000, 37.55],
      [1356562800000, 37.30],
      [1356649200000, 36.90],
      [1356908400000, 37.68],
      [1357081200000, 38.34],
      [1357167600000, 37.75],
      [1357254000000, 38.13],
      [1357513200000, 37.94],
      [1357599600000, 38.14],
      [1357686000000, 38.66],
      [1357772400000, 38.62],
      [1357858800000, 38.09],
      [1358118000000, 38.16],
      [1358204400000, 38.15],
      [1358290800000, 37.88],
      [1358377200000, 37.73],
      [1358463600000, 37.98],
      [1358809200000, 37.95],
      [1358895600000, 38.25],
      [1358982000000, 38.10],
      [1359068400000, 38.32],
      [1359327600000, 38.24],
      [1359414000000, 38.52],
      [1359500400000, 37.94],
      [1359586800000, 37.83],
      [1359673200000, 38.34],
      [1359932400000, 38.10],
      [1360018800000, 38.51],
      [1360105200000, 38.40],
      [1360191600000, 38.07],
      [1360278000000, 39.12],
      [1360537200000, 38.64],
      [1360623600000, 38.89],
      [1360710000000, 38.81],
      [1360796400000, 38.61],
      [1360882800000, 38.63],
      [1361228400000, 38.99],
      [1361314800000, 38.77],
      [1361401200000, 38.34],
      [1361487600000, 38.55],
      [1361746800000, 38.11],
      [1361833200000, 38.59],
      [1361919600000, 39.60],
    ]
  }],
  chart: {
    id: 'area-datetime',
    type: 'area',
    height: 350,
    zoom: {
      autoScaleYaxis: true
    }
  },
  annotations: {
    yaxis: [{
      y: 30,
      borderColor: '#999',
      label: {
        show: true,
        text: 'Support',
        style: {
          color: "#fff",
          background: '#00E396'
        }
      }
    }],
    xaxis: [{
      x: new Date('14 Nov 2012').getTime(),
      borderColor: '#999',
      yAxisIndex: 0,
      label: {
        show: true,
        text: 'Rally',
        style: {
          color: "#fff",
          background: '#775DD0'
        }
      }
    }]
  },
  dataLabels: {
    enabled: false
  },
  markers: {
    size: 0,
    style: 'hollow',
  },
  xaxis: {
    type: 'datetime',
    min: new Date('01 Mar 2012').getTime(),
    tickAmount: 6,
  },
  tooltip: {
    x: {
      format: 'dd MMM yyyy'
    }
  },
  colors: ['#6D71FA', '#33b2df'],
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 1,
      opacityFrom: 0.7,
      opacityTo: 0.9,
      stops: [0, 100]
    }
  },
};


const areaSelector2 = document.querySelector("#areaChart2");
if (areaSelector2) {
  var areaChart2 = new ApexCharts(areaSelector2, area2);
  areaChart2.render();
}


var resetCssClasses = function (activeEl) {
  var els = document.querySelectorAll('button')
  Array.prototype.forEach.call(els, function (el) {
    el.classList.remove('active')
  })

  activeEl.target.classList.add('active')
}

document.addEventListener('DOMContentLoaded', function () {
  const oneMonthButton = document.querySelector('#one_month');
  if (oneMonthButton) {
    oneMonthButton.addEventListener('click', function (e) {
      resetCssClasses(e)

      areaChart2.zoomX(
        new Date('28 Jan 2013').getTime(),
        new Date('27 Feb 2013').getTime()
      )
    })
  }
})


document.addEventListener('DOMContentLoaded', function () {
  const sixMonthButton = document.querySelector('#six_month');
  if (sixMonthButton) {
    sixMonthButton.addEventListener('click', function (e) {
      resetCssClasses(e)

      areaChart2.zoomX(
        new Date('27 Sep 2012').getTime(),
        new Date('27 Feb 2013').getTime()
      )
    })
  }
})


document.addEventListener('DOMContentLoaded', function () {
  const oneYearButton = document.querySelector('#one_year');
  if (oneYearButton) {
    oneYearButton.addEventListener('click', function (e) {
      resetCssClasses(e)

      areaChart2.zoomX(
        new Date('27 Feb 2012').getTime(),
        new Date('27 Feb 2013').getTime()
      )
    })
  }
})

document.addEventListener('DOMContentLoaded', function () {
  const ytdButton = document.querySelector('#ytd');
  // console.log('ytdButton:', ytdButton);
  if (ytdButton) {
    ytdButton.addEventListener('click', function (e) {
      resetCssClasses(e)

      areaChart2.zoomX()
    })
  }
})



document.addEventListener('DOMContentLoaded', function () {
  const allButton = document.querySelector('#all');
  if (allButton) {
    allButton.addEventListener('click', function (e) {
      resetCssClasses(e)

      areaChart2.zoomX()
    })
  }
})



// area chart 3  ---  Datetime X-Axis line chart

const area3 = {
  series: [{
    name: 'north',
    data: [{
      x: 1996,
      y: 322
    },
    {
      x: 1997,
      y: 324
    },
    {
      x: 1998,
      y: 329
    },
    {
      x: 1999,
      y: 342
    },
    {
      x: 2000,
      y: 348
    },
    {
      x: 2001,
      y: 334
    },
    {
      x: 2002,
      y: 325
    },
    {
      x: 2003,
      y: 316
    },
    {
      x: 2004,
      y: 318
    },
    {
      x: 2005,
      y: 330
    },
    {
      x: 2006,
      y: 355
    },
    {
      x: 2007,
      y: 366
    },
    {
      x: 2008,
      y: 337
    },
    {
      x: 2009,
      y: 352
    },
    {
      x: 2010,
      y: 377
    },
    {
      x: 2011,
      y: 383
    },
    {
      x: 2012,
      y: 344
    },
    {
      x: 2013,
      y: 366
    },
    {
      x: 2014,
      y: 389
    },
    {
      x: 2015,
      y: 334
    }
    ]
  }, {
    name: 'south',
    data: [{
      x: 1996,
      y: 162
    },
    {
      x: 1997,
      y: 90
    },
    {
      x: 1998,
      y: 50
    },
    {
      x: 1999,
      y: 77
    },
    {
      x: 2000,
      y: 35
    },
    {
      x: 2001,
      y: -45
    },
    {
      x: 2002,
      y: -88
    },
    {
      x: 2003,
      y: -120
    },
    {
      x: 2004,
      y: -156
    },
    {
      x: 2005,
      y: -123
    },
    {
      x: 2006,
      y: -88
    },
    {
      x: 2007,
      y: -66
    },
    {
      x: 2008,
      y: -45
    },
    {
      x: 2009,
      y: -29
    },
    {
      x: 2010,
      y: -45
    },
    {
      x: 2011,
      y: -88
    },
    {
      x: 2012,
      y: -132
    },
    {
      x: 2013,
      y: -146
    },
    {
      x: 2014,
      y: -169
    },
    {
      x: 2015,
      y: -184
    }
    ]
  }],
  chart: {
    type: 'area',
    height: 350
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'straight'
  },

  title: {
    text: 'Area with Negative Values',
    align: 'left',
    style: {
      fontSize: '14px'
    }
  },
  xaxis: {
    type: 'datetime',
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    }
  },
  yaxis: {
    tickAmount: 4,
    floating: false,

    labels: {
      style: {
        colors: '#8e8da4',
      },
      offsetY: -7,
      offsetX: 0,
    },
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false
    }
  },
  fill: {
    opacity: 0.5
  },
  tooltip: {
    x: {
      format: "yyyy",
    },
    fixed: {
      enabled: false,
      position: 'topRight'
    }
  },
  grid: {
    yaxis: {
      lines: {
        offsetX: -30
      }
    },
    padding: {
      left: 20
    }
  }
};



const areaSelector3 = document.querySelector("#areaChart3");
if (areaSelector3) {
  const areaChart3 = new ApexCharts(areaSelector3, area3);
  areaChart3.render();
}



// area chart 4  ---  Datetime X-Axis line chart

const area4 = {
  series: [{
    name: 'Network',
    data: [{
      x: 'Dec 23 2017',
      y: null
    },
    {
      x: 'Dec 24 2017',
      y: 44
    },
    {
      x: 'Dec 25 2017',
      y: 31
    },
    {
      x: 'Dec 26 2017',
      y: 38
    },
    {
      x: 'Dec 27 2017',
      y: null
    },
    {
      x: 'Dec 28 2017',
      y: 32
    },
    {
      x: 'Dec 29 2017',
      y: 55
    },
    {
      x: 'Dec 30 2017',
      y: 51
    },
    {
      x: 'Dec 31 2017',
      y: 67
    },
    {
      x: 'Jan 01 2018',
      y: 22
    },
    {
      x: 'Jan 02 2018',
      y: 34
    },
    {
      x: 'Jan 03 2018',
      y: null
    },
    {
      x: 'Jan 04 2018',
      y: null
    },
    {
      x: 'Jan 05 2018',
      y: 11
    },
    {
      x: 'Jan 06 2018',
      y: 4
    },
    {
      x: 'Jan 07 2018',
      y: 15,
    },
    {
      x: 'Jan 08 2018',
      y: null
    },
    {
      x: 'Jan 09 2018',
      y: 9
    },
    {
      x: 'Jan 10 2018',
      y: 34
    },
    {
      x: 'Jan 11 2018',
      y: null
    },
    {
      x: 'Jan 12 2018',
      y: null
    },
    {
      x: 'Jan 13 2018',
      y: 13
    },
    {
      x: 'Jan 14 2018',
      y: null
    }
    ],
  }],
  chart: {
    type: 'area',
    height: 350,
    animations: {
      enabled: false
    },
    zoom: {
      enabled: false
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.8,
    type: 'pattern',
    pattern: {
      style: ['verticalLines', 'horizontalLines'],
      width: 5,
      height: 6
    },
  },
  markers: {
    size: 5,
    hover: {
      size: 9
    }
  },
  title: {
    text: 'Network Monitoring',
  },
  tooltip: {
    intersect: true,
    shared: false
  },
  theme: {
    palette: 'palette1'
  },
  xaxis: {
    type: 'datetime',
  },
  yaxis: {
    title: {
      text: 'Bytes Received'
    }
  }
};


const areaSelector4 = document.querySelector("#areaChart4");
if (areaSelector4) {
  const areaChart4 = new ApexCharts(areaSelector4, area4);
  areaChart4.render();
}


// area chart 5  ---  
const area5 = {
  chart: {
    type: 'area',
    height: 350,
    toolbar: {
      show: false
    },
    zoom: {
      enabled: false
    },
    animations: {
      enabled: true,
      easing: 'easeinout',
      speed: 800,
    }
  },
  stroke: {
    curve: 'smooth',
    width: 2,
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 1,
      gradientToColors: ['#6D71FA'],  // Ending color of the gradient
      inverseColors: false,
      opacityFrom: 0.8,
      opacityTo: 0.2,
      stops: [0, 100]
    },
    colors: ['#6D71FA'],  // Starting color of the gradient
  },
  dataLabels: {
    enabled: false
  },
  markers: {
    size: 0,
    colors: ['#fff'],
    strokeColors: '#5B65FF',
    strokeWidth: 3,
    hover: {
      size: 4,
    },
    // Customize marker visibility for specific data points
    discrete: [
      {
        seriesIndex: 0,
        dataPointIndex: 7, // Index for September data point
        fillColor: '#fff',
        strokeColor: '#5B65FF',
        size: 6
      }
    ]
  },
  tooltip: {
    enabled: true,
    custom: function ({ series, seriesIndex, dataPointIndex, w }) {
      const data = series[seriesIndex][dataPointIndex];
      const date = w.globals.labels[dataPointIndex];
      return `
        <div style="background: white; border-radius: 8px; padding: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
          <div style="font-size: 12px; color: #888; margin-bottom: 4px;">${date}</div>
          <div class="d-flex align-items-center gap-2">
            <p style="font-size: 20px; font-weight: bold; color: #000;" line-height: 1; class="mb-0"> ${data.toLocaleString()}</p>
            <span class="badge bg-success">+3%</span>
          </div>
        </div>
      `;
    },
    style: {
      fontSize: '14px',
    },
    marker: {
      show: false
    }
  },
  series: [{
    name: 'Data',
    data: [30000, 45000, 35000, 60000, 90000, 80000, 70000, 100000, 75000, 50000, 40000]
  }],
  xaxis: {
    // Show full dates instead of only months
    categories: ['Mar-25', 'Feb-25', 'Jan-25', 'Dec-24', 'Nov-24', 'Oct-24', 'Sept-24', 'Aug-24', 'July-24', 'Jun-24', 'May-24', 'Apr-24'],
    labels: {
      style: {
        colors: '#888',
        fontSize: '12px',
      }
    },
  },
  yaxis: {
    labels: {
      style: {
        colors: '#888',
        fontSize: '12px',
      },
      formatter: function (val) {
        return val >= 1000 ? (val / 1000) + 'K' : val;
      }
    }
  },
  grid: {
    borderColor: '#f1f1f1',
  }
};

const areaSelector5 = document.querySelector("#areaChart5");
if (areaSelector5) {
  const areaChart5 = new ApexCharts(areaSelector5, area5);
  areaChart5.render();
}



// ********************* Area chart end here ***************** //


// ********************* Mix/peity chart start here ***************** //

//  Mixchart 1 -------- basic
const mix1 = {
  series: [{
    name: 'Website Blog',
    type: 'column',
    data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
  }, {
    name: 'Social Media',
    type: 'line',
    data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
  }],
  chart: {
    height: 350,
    type: 'line',
  },
  stroke: {
    width: [0, 2],
  },

  colors: ['#6D71FA', '#0b1531c7'],

  title: {
    text: 'Traffic Sources'
  },
  dataLabels: {
    enabled: true,
    enabledOnSeries: [1]
  },
  labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
  xaxis: {
    type: 'datetime'
  },
  yaxis: [{
    title: {
      text: 'Website Blog',
    },

  }, {
    opposite: true,
    title: {
      text: 'Social Media'
    }
  }]
};



const mixSelector1 = document.querySelector("#mixChart1");
if (mixSelector1) {
  const mixChart1 = new ApexCharts(mixSelector1, mix1);
  mixChart1.render();
}


//  Mixchart 2 -------- basic
const mix2 = {
  series: [{
    name: 'Income',
    type: 'column',
    data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
  }, {
    name: 'Cashflow',
    type: 'column',
    data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
  }, {
    name: 'Revenue',
    type: 'line',
    data: [20, 29, 37, 36, 44, 45, 50, 58]
  }],
  chart: {
    height: 350,
    type: 'line',
    stacked: false
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: [1, 1, 4]
  },
  title: {
    text: 'XYZ - Stock Analysis (2009 - 2016)',
    align: 'left',
    offsetX: 110
  },
  xaxis: {
    categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
  },
  yaxis: [{
    axisTicks: {
      show: true,
    },
    axisBorder: {
      show: true,
      color: '#008FFB'
    },
    labels: {
      style: {
        colors: '#008FFB',
      }
    },
    title: {
      text: "Income (thousand crores)",
      style: {
        color: '#008FFB',
      }
    },
    tooltip: {
      enabled: true
    }
  },
  {
    seriesName: 'Income',
    opposite: true,
    axisTicks: {
      show: true,
    },
    axisBorder: {
      show: true,
      color: '#00E396'
    },
    labels: {
      style: {
        colors: '#00E396',
      }
    },
    title: {
      text: "Operating Cashflow (thousand crores)",
      style: {
        color: '#00E396',
      }
    },
  },
  {
    seriesName: 'Revenue',
    opposite: true,
    axisTicks: {
      show: true,
    },
    axisBorder: {
      show: true,
      color: '#FEB019'
    },
    labels: {
      style: {
        colors: '#FEB019',
      },
    },
    title: {
      text: "Revenue (thousand crores)",
      style: {
        color: '#FEB019',
      }
    }
  },
  ],
  tooltip: {
    fixed: {
      enabled: true,
      position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
      offsetY: 30,
      offsetX: 60
    },
  },
  legend: {
    horizontalAlign: 'left',
    offsetX: 40
  }
};

const mixSelector2 = document.querySelector("#mixChart2");
if (mixSelector2) {
  const mixChart2 = new ApexCharts(mixSelector2, mix2);
  mixChart2.render();
}


//  Mixchart 2 -------- basic
const mix3 = {
  series: [{
    name: 'TEAM A',
    type: 'area',
    data: [44, 55, 31, 47, 31, 43, 26, 41, 31, 47, 33]
  }, {
    name: 'TEAM B',
    type: 'line',
    data: [55, 69, 45, 61, 43, 54, 37, 52, 44, 61, 43]
  }],
  chart: {
    height: 350,
    type: 'line',
  },
  stroke: {
    curve: 'smooth'
  },
  fill: {
    type: 'solid',
    opacity: [0.35, 1],
  },
  labels: ['Dec 01', 'Dec 02', 'Dec 03', 'Dec 04', 'Dec 05', 'Dec 06', 'Dec 07', 'Dec 08', 'Dec 09 ', 'Dec 10', 'Dec 11'],
  markers: {
    size: 0
  },
  yaxis: [{
    title: {
      text: 'Series A',
    },
  },
  {
    opposite: true,
    title: {
      text: 'Series B',
    },
  },
  ],
  tooltip: {
    shared: true,
    intersect: false,
    y: {
      formatter: function (y) {
        if (typeof y !== "undefined") {
          return y.toFixed(0) + " points";
        }
        return y;
      }
    }
  }
};


const mixSelector3 = document.querySelector("#mixChart3");
if (mixSelector3) {
  const mixChart3 = new ApexCharts(mixSelector3, mix3);
  mixChart3.render();
}



//  Mixchart 4 -------- basic
const mix4 = {
  series: [{
    name: 'TEAM A',
    type: 'column',
    data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
  }, {
    name: 'TEAM B',
    type: 'area',
    data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
  }, {
    name: 'TEAM C',
    type: 'line',
    data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
  }],
  chart: {
    height: 350,
    type: 'line',
    stacked: false,
  },
  stroke: {
    width: [0, 2, 5],
    curve: 'smooth'
  },
  plotOptions: {
    bar: {
      columnWidth: '50%'
    }
  },

  fill: {
    opacity: [0.85, 0.25, 1],
    gradient: {
      inverseColors: false,
      shade: 'light',
      type: "vertical",
      opacityFrom: 0.85,
      opacityTo: 0.55,
      stops: [0, 100, 100, 100]
    }
  },
  labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003',
    '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'
  ],
  markers: {
    size: 0
  },
  xaxis: {
    type: 'datetime'
  },
  yaxis: {
    title: {
      text: 'Points',
    },
    min: 0
  },
  tooltip: {
    shared: true,
    intersect: false,
    y: {
      formatter: function (y) {
        if (typeof y !== "undefined") {
          return y.toFixed(0) + " points";
        }
        return y;

      }
    }
  }
};


const mixSelector4 = document.querySelector("#mixChart4");
if (mixSelector4) {
  const mixChart4 = new ApexCharts(mixSelector4, mix4);
  mixChart4.render();
}



//  Mixchart 5 -------- basic
const mix5 = {
  series: [{
    type: 'rangeArea',
    name: 'Team B Range',

    data: [{
      x: 'Jan',
      y: [1100, 1900]
    },
    {
      x: 'Feb',
      y: [1200, 1800]
    },
    {
      x: 'Mar',
      y: [900, 2900]
    },
    {
      x: 'Apr',
      y: [1400, 2700]
    },
    {
      x: 'May',
      y: [2600, 3900]
    },
    {
      x: 'Jun',
      y: [500, 1700]
    },
    {
      x: 'Jul',
      y: [1900, 2300]
    },
    {
      x: 'Aug',
      y: [1000, 1500]
    }
    ]
  },

  {
    type: 'rangeArea',
    name: 'Team A Range',
    data: [{
      x: 'Jan',
      y: [3100, 3400]
    },
    {
      x: 'Feb',
      y: [4200, 5200]
    },
    {
      x: 'Mar',
      y: [3900, 4900]
    },
    {
      x: 'Apr',
      y: [3400, 3900]
    },
    {
      x: 'May',
      y: [5100, 5900]
    },
    {
      x: 'Jun',
      y: [5400, 6700]
    },
    {
      x: 'Jul',
      y: [4300, 4600]
    },
    {
      x: 'Aug',
      y: [2100, 2900]
    }
    ]
  },

  {
    type: 'line',
    name: 'Team B Median',
    data: [{
      x: 'Jan',
      y: 1500
    },
    {
      x: 'Feb',
      y: 1700
    },
    {
      x: 'Mar',
      y: 1900
    },
    {
      x: 'Apr',
      y: 2200
    },
    {
      x: 'May',
      y: 3000
    },
    {
      x: 'Jun',
      y: 1000
    },
    {
      x: 'Jul',
      y: 2100
    },
    {
      x: 'Aug',
      y: 1200
    },
    {
      x: 'Sep',
      y: 1800
    },
    {
      x: 'Oct',
      y: 2000
    }
    ]
  },
  {
    type: 'line',
    name: 'Team A Median',
    data: [{
      x: 'Jan',
      y: 3300
    },
    {
      x: 'Feb',
      y: 4900
    },
    {
      x: 'Mar',
      y: 4300
    },
    {
      x: 'Apr',
      y: 3700
    },
    {
      x: 'May',
      y: 5500
    },
    {
      x: 'Jun',
      y: 5900
    },
    {
      x: 'Jul',
      y: 4500
    },
    {
      x: 'Aug',
      y: 2400
    },
    {
      x: 'Sep',
      y: 2100
    },
    {
      x: 'Oct',
      y: 1500
    }
    ]
  }
  ],
  chart: {
    height: 350,
    type: 'rangeArea',
    animations: {
      speed: 500
    }
  },
  colors: ['#d4526e', '#33b2df', '#d4526e', '#33b2df'],
  dataLabels: {
    enabled: false
  },
  fill: {
    opacity: [0.24, 0.24, 1, 1]
  },
  forecastDataPoints: {
    count: 2
  },
  stroke: {
    curve: 'straight',
    width: [0, 0, 2, 2]
  },
  legend: {
    show: true,
    customLegendItems: ['Team B', 'Team A'],
    inverseOrder: true
  },
  title: {
    text: 'Range Area with Forecast Line (Combo)'
  },
  markers: {
    hover: {
      sizeOffset: 5
    }
  }
};


const mixSelector5 = document.querySelector("#mixChart5");
if (mixSelector5) {
  var mixChart5 = new ApexCharts(mixSelector5, mix5);
  mixChart5.render();
}

// ********************* Mix/peity chart end here ***************** //




// ********************* candlestick chart start here ***************** //
//  candlestick 1 -------- basic
const candle1 = {
  series: [{
    data: [{
      x: new Date(1538778600000),
      y: [6629.81, 6650.5, 6623.04, 6633.33]
    },
    {
      x: new Date(1538780400000),
      y: [6632.01, 6643.59, 6620, 6630.11]
    },
    {
      x: new Date(1538782200000),
      y: [6630.71, 6648.95, 6623.34, 6635.65]
    },
    {
      x: new Date(1538784000000),
      y: [6635.65, 6651, 6629.67, 6638.24]
    },
    {
      x: new Date(1538785800000),
      y: [6638.24, 6640, 6620, 6624.47]
    },
    {
      x: new Date(1538787600000),
      y: [6624.53, 6636.03, 6621.68, 6624.31]
    },
    {
      x: new Date(1538789400000),
      y: [6624.61, 6632.2, 6617, 6626.02]
    },
    {
      x: new Date(1538791200000),
      y: [6627, 6627.62, 6584.22, 6603.02]
    },
    {
      x: new Date(1538793000000),
      y: [6605, 6608.03, 6598.95, 6604.01]
    },
    {
      x: new Date(1538794800000),
      y: [6604.5, 6614.4, 6602.26, 6608.02]
    },
    {
      x: new Date(1538796600000),
      y: [6608.02, 6610.68, 6601.99, 6608.91]
    },
    {
      x: new Date(1538798400000),
      y: [6608.91, 6618.99, 6608.01, 6612]
    },
    {
      x: new Date(1538800200000),
      y: [6612, 6615.13, 6605.09, 6612]
    },
    {
      x: new Date(1538802000000),
      y: [6612, 6624.12, 6608.43, 6622.95]
    },
    {
      x: new Date(1538803800000),
      y: [6623.91, 6623.91, 6615, 6615.67]
    },
    {
      x: new Date(1538805600000),
      y: [6618.69, 6618.74, 6610, 6610.4]
    },
    {
      x: new Date(1538807400000),
      y: [6611, 6622.78, 6610.4, 6614.9]
    },
    {
      x: new Date(1538809200000),
      y: [6614.9, 6626.2, 6613.33, 6623.45]
    },
    {
      x: new Date(1538811000000),
      y: [6623.48, 6627, 6618.38, 6620.35]
    },
    {
      x: new Date(1538812800000),
      y: [6619.43, 6620.35, 6610.05, 6615.53]
    },
    {
      x: new Date(1538814600000),
      y: [6615.53, 6617.93, 6610, 6615.19]
    },
    {
      x: new Date(1538816400000),
      y: [6615.19, 6621.6, 6608.2, 6620]
    },
    {
      x: new Date(1538818200000),
      y: [6619.54, 6625.17, 6614.15, 6620]
    },
    {
      x: new Date(1538820000000),
      y: [6620.33, 6634.15, 6617.24, 6624.61]
    },
    {
      x: new Date(1538821800000),
      y: [6625.95, 6626, 6611.66, 6617.58]
    },
    {
      x: new Date(1538823600000),
      y: [6619, 6625.97, 6595.27, 6598.86]
    },
    {
      x: new Date(1538825400000),
      y: [6598.86, 6598.88, 6570, 6587.16]
    },
    {
      x: new Date(1538827200000),
      y: [6588.86, 6600, 6580, 6593.4]
    },
    {
      x: new Date(1538829000000),
      y: [6593.99, 6598.89, 6585, 6587.81]
    },
    {
      x: new Date(1538830800000),
      y: [6587.81, 6592.73, 6567.14, 6578]
    },
    {
      x: new Date(1538832600000),
      y: [6578.35, 6581.72, 6567.39, 6579]
    },
    {
      x: new Date(1538834400000),
      y: [6579.38, 6580.92, 6566.77, 6575.96]
    },
    {
      x: new Date(1538836200000),
      y: [6575.96, 6589, 6571.77, 6588.92]
    },
    {
      x: new Date(1538838000000),
      y: [6588.92, 6594, 6577.55, 6589.22]
    },
    {
      x: new Date(1538839800000),
      y: [6589.3, 6598.89, 6589.1, 6596.08]
    },
    {
      x: new Date(1538841600000),
      y: [6597.5, 6600, 6588.39, 6596.25]
    },
    {
      x: new Date(1538843400000),
      y: [6598.03, 6600, 6588.73, 6595.97]
    },
    {
      x: new Date(1538845200000),
      y: [6595.97, 6602.01, 6588.17, 6602]
    },
    {
      x: new Date(1538847000000),
      y: [6602, 6607, 6596.51, 6599.95]
    },
    {
      x: new Date(1538848800000),
      y: [6600.63, 6601.21, 6590.39, 6591.02]
    },
    {
      x: new Date(1538850600000),
      y: [6591.02, 6603.08, 6591, 6591]
    },
    {
      x: new Date(1538852400000),
      y: [6591, 6601.32, 6585, 6592]
    },
    {
      x: new Date(1538854200000),
      y: [6593.13, 6596.01, 6590, 6593.34]
    },
    {
      x: new Date(1538856000000),
      y: [6593.34, 6604.76, 6582.63, 6593.86]
    },
    {
      x: new Date(1538857800000),
      y: [6593.86, 6604.28, 6586.57, 6600.01]
    },
    {
      x: new Date(1538859600000),
      y: [6601.81, 6603.21, 6592.78, 6596.25]
    },
    {
      x: new Date(1538861400000),
      y: [6596.25, 6604.2, 6590, 6602.99]
    },
    {
      x: new Date(1538863200000),
      y: [6602.99, 6606, 6584.99, 6587.81]
    },
    {
      x: new Date(1538865000000),
      y: [6587.81, 6595, 6583.27, 6591.96]
    },
    {
      x: new Date(1538866800000),
      y: [6591.97, 6596.07, 6585, 6588.39]
    },
    {
      x: new Date(1538868600000),
      y: [6587.6, 6598.21, 6587.6, 6594.27]
    },
    {
      x: new Date(1538870400000),
      y: [6596.44, 6601, 6590, 6596.55]
    },
    {
      x: new Date(1538872200000),
      y: [6598.91, 6605, 6596.61, 6600.02]
    },
    {
      x: new Date(1538874000000),
      y: [6600.55, 6605, 6589.14, 6593.01]
    },
    {
      x: new Date(1538875800000),
      y: [6593.15, 6605, 6592, 6603.06]
    },
    {
      x: new Date(1538877600000),
      y: [6603.07, 6604.5, 6599.09, 6603.89]
    },
    {
      x: new Date(1538879400000),
      y: [6604.44, 6604.44, 6600, 6603.5]
    },
    {
      x: new Date(1538881200000),
      y: [6603.5, 6603.99, 6597.5, 6603.86]
    },
    {
      x: new Date(1538883000000),
      y: [6603.85, 6605, 6600, 6604.07]
    },
    {
      x: new Date(1538884800000),
      y: [6604.98, 6606, 6604.07, 6606]
    },
    ]
  }],
  chart: {
    type: 'candlestick',
    height: 350
  },
  title: {
    text: 'CandleStick Chart',
    align: 'left'
  },
  xaxis: {
    type: 'datetime'
  },
  yaxis: {
    tooltip: {
      enabled: true
    }
  }
};


const candleSelector1 = document.querySelector("#candleChart1");
if (candleSelector1) {
  const candleChart1 = new ApexCharts(candleSelector1, candle1);
  candleChart1.render();
}


//  candlestick 2 -------- basic

const candle2 = {
  series: [{
    name: 'line',
    type: 'line',
    data: [{
      x: new Date(1538778600000),
      y: 6604
    }, {
      x: new Date(1538782200000),
      y: 6602
    }, {
      x: new Date(1538814600000),
      y: 6607
    }, {
      x: new Date(1538884800000),
      y: 6620
    }]
  }, {
    name: 'candle',
    type: 'candlestick',
    data: [{
      x: new Date(1538778600000),
      y: [6629.81, 6650.5, 6623.04, 6633.33]
    },
    {
      x: new Date(1538780400000),
      y: [6632.01, 6643.59, 6620, 6630.11]
    },
    {
      x: new Date(1538782200000),
      y: [6630.71, 6648.95, 6623.34, 6635.65]
    },
    {
      x: new Date(1538784000000),
      y: [6635.65, 6651, 6629.67, 6638.24]
    },
    {
      x: new Date(1538785800000),
      y: [6638.24, 6640, 6620, 6624.47]
    },
    {
      x: new Date(1538787600000),
      y: [6624.53, 6636.03, 6621.68, 6624.31]
    },
    {
      x: new Date(1538789400000),
      y: [6624.61, 6632.2, 6617, 6626.02]
    },
    {
      x: new Date(1538791200000),
      y: [6627, 6627.62, 6584.22, 6603.02]
    },
    {
      x: new Date(1538793000000),
      y: [6605, 6608.03, 6598.95, 6604.01]
    },
    {
      x: new Date(1538794800000),
      y: [6604.5, 6614.4, 6602.26, 6608.02]
    },
    {
      x: new Date(1538796600000),
      y: [6608.02, 6610.68, 6601.99, 6608.91]
    },
    {
      x: new Date(1538798400000),
      y: [6608.91, 6618.99, 6608.01, 6612]
    },
    {
      x: new Date(1538800200000),
      y: [6612, 6615.13, 6605.09, 6612]
    },
    {
      x: new Date(1538802000000),
      y: [6612, 6624.12, 6608.43, 6622.95]
    },
    {
      x: new Date(1538803800000),
      y: [6623.91, 6623.91, 6615, 6615.67]
    },
    {
      x: new Date(1538805600000),
      y: [6618.69, 6618.74, 6610, 6610.4]
    },
    {
      x: new Date(1538807400000),
      y: [6611, 6622.78, 6610.4, 6614.9]
    },
    {
      x: new Date(1538809200000),
      y: [6614.9, 6626.2, 6613.33, 6623.45]
    },
    {
      x: new Date(1538811000000),
      y: [6623.48, 6627, 6618.38, 6620.35]
    },
    {
      x: new Date(1538812800000),
      y: [6619.43, 6620.35, 6610.05, 6615.53]
    },
    {
      x: new Date(1538814600000),
      y: [6615.53, 6617.93, 6610, 6615.19]
    },
    {
      x: new Date(1538816400000),
      y: [6615.19, 6621.6, 6608.2, 6620]
    },
    {
      x: new Date(1538818200000),
      y: [6619.54, 6625.17, 6614.15, 6620]
    },
    {
      x: new Date(1538820000000),
      y: [6620.33, 6634.15, 6617.24, 6624.61]
    },
    {
      x: new Date(1538821800000),
      y: [6625.95, 6626, 6611.66, 6617.58]
    },
    {
      x: new Date(1538823600000),
      y: [6619, 6625.97, 6595.27, 6598.86]
    },
    {
      x: new Date(1538825400000),
      y: [6598.86, 6598.88, 6570, 6587.16]
    },
    {
      x: new Date(1538827200000),
      y: [6588.86, 6600, 6580, 6593.4]
    },
    {
      x: new Date(1538829000000),
      y: [6593.99, 6598.89, 6585, 6587.81]
    },
    {
      x: new Date(1538830800000),
      y: [6587.81, 6592.73, 6567.14, 6578]
    },
    {
      x: new Date(1538832600000),
      y: [6578.35, 6581.72, 6567.39, 6579]
    },
    {
      x: new Date(1538834400000),
      y: [6579.38, 6580.92, 6566.77, 6575.96]
    },
    {
      x: new Date(1538836200000),
      y: [6575.96, 6589, 6571.77, 6588.92]
    },
    {
      x: new Date(1538838000000),
      y: [6588.92, 6594, 6577.55, 6589.22]
    },
    {
      x: new Date(1538839800000),
      y: [6589.3, 6598.89, 6589.1, 6596.08]
    },
    {
      x: new Date(1538841600000),
      y: [6597.5, 6600, 6588.39, 6596.25]
    },
    {
      x: new Date(1538843400000),
      y: [6598.03, 6600, 6588.73, 6595.97]
    },
    {
      x: new Date(1538845200000),
      y: [6595.97, 6602.01, 6588.17, 6602]
    },
    {
      x: new Date(1538847000000),
      y: [6602, 6607, 6596.51, 6599.95]
    },
    {
      x: new Date(1538848800000),
      y: [6600.63, 6601.21, 6590.39, 6591.02]
    },
    {
      x: new Date(1538850600000),
      y: [6591.02, 6603.08, 6591, 6591]
    },
    {
      x: new Date(1538852400000),
      y: [6591, 6601.32, 6585, 6592]
    },
    {
      x: new Date(1538854200000),
      y: [6593.13, 6596.01, 6590, 6593.34]
    },
    {
      x: new Date(1538856000000),
      y: [6593.34, 6604.76, 6582.63, 6593.86]
    },
    {
      x: new Date(1538857800000),
      y: [6593.86, 6604.28, 6586.57, 6600.01]
    },
    {
      x: new Date(1538859600000),
      y: [6601.81, 6603.21, 6592.78, 6596.25]
    },
    {
      x: new Date(1538861400000),
      y: [6596.25, 6604.2, 6590, 6602.99]
    },
    {
      x: new Date(1538863200000),
      y: [6602.99, 6606, 6584.99, 6587.81]
    },
    {
      x: new Date(1538865000000),
      y: [6587.81, 6595, 6583.27, 6591.96]
    },
    {
      x: new Date(1538866800000),
      y: [6591.97, 6596.07, 6585, 6588.39]
    },
    {
      x: new Date(1538868600000),
      y: [6587.6, 6598.21, 6587.6, 6594.27]
    },
    {
      x: new Date(1538870400000),
      y: [6596.44, 6601, 6590, 6596.55]
    },
    {
      x: new Date(1538872200000),
      y: [6598.91, 6605, 6596.61, 6600.02]
    },
    {
      x: new Date(1538874000000),
      y: [6600.55, 6605, 6589.14, 6593.01]
    },
    {
      x: new Date(1538875800000),
      y: [6593.15, 6605, 6592, 6603.06]
    },
    {
      x: new Date(1538877600000),
      y: [6603.07, 6604.5, 6599.09, 6603.89]
    },
    {
      x: new Date(1538879400000),
      y: [6604.44, 6604.44, 6600, 6603.5]
    },
    {
      x: new Date(1538881200000),
      y: [6603.5, 6603.99, 6597.5, 6603.86]
    },
    {
      x: new Date(1538883000000),
      y: [6603.85, 6605, 6600, 6604.07]
    },
    {
      x: new Date(1538884800000),
      y: [6604.98, 6606, 6604.07, 6606]
    },
    ]
  }],
  chart: {
    height: 350,
    type: 'line',
  },
  title: {
    text: 'CandleStick Chart',
    align: 'left'
  },
  stroke: {
    width: [3, 1]
  },
  tooltip: {
    shared: true,
    custom: [function ({
      seriesIndex,
      dataPointIndex,
      w
    }) {
      return w.globals.series[seriesIndex][dataPointIndex]
    }, function ({
      seriesIndex,
      dataPointIndex,
      w
    }) {
      var o = w.globals.seriesCandleO[seriesIndex][dataPointIndex]
      var h = w.globals.seriesCandleH[seriesIndex][dataPointIndex]
      var l = w.globals.seriesCandleL[seriesIndex][dataPointIndex]
      var c = w.globals.seriesCandleC[seriesIndex][dataPointIndex]
      return (
        ''
      )
    }]
  },
  xaxis: {
    type: 'datetime'
  }
};


const candleSelector2 = document.querySelector("#candleChart2");
if (candleSelector2) {
  const candleChart2 = new ApexCharts(candleSelector2, candle2);
  candleChart2.render();
}



//  candlestick 3 -------- basic
const candle3 = {
  series: [{
    data: [{
      x: 'INTC',
      y: 1.2
    },
    {
      x: 'GS',
      y: 0.4
    },
    {
      x: 'CVX',
      y: -1.4
    },
    {
      x: 'GE',
      y: 2.7
    },
    {
      x: 'CAT',
      y: -0.3
    },
    {
      x: 'RTX',
      y: 5.1
    },
    {
      x: 'CSCO',
      y: -2.3
    },
    {
      x: 'JNJ',
      y: 2.1
    },
    {
      x: 'PG',
      y: 0.3
    },
    {
      x: 'TRV',
      y: 0.12
    },
    {
      x: 'MMM',
      y: -2.31
    },
    {
      x: 'NKE',
      y: 3.98
    },
    {
      x: 'IYT',
      y: 1.67
    }
    ]
  }],
  legend: {
    show: false
  },
  chart: {
    height: 350,
    type: 'treemap'
  },
  title: {
    text: 'Treemap with Color scale'
  },
  dataLabels: {
    enabled: true,
    style: {
      fontSize: '12px',
    },
    formatter: function (text, op) {
      return [text, op.value]
    },
    offsetY: -4
  },
  plotOptions: {
    treemap: {
      enableShades: true,
      shadeIntensity: 0.5,
      reverseNegativeShade: true,
      colorScale: {
        ranges: [{
          from: -6,
          to: 0,
          color: '#CD363A'
        },
        {
          from: 0.001,
          to: 6,
          color: '#52B12C'
        }
        ]
      }
    }
  }
};


const candleSelector3 = document.querySelector("#candleChart3");
if (candleSelector3) {
  const candleChart3 = new ApexCharts(candleSelector3, candle3);
  candleChart3.render();
}



// ********************* candlestick chart end here ***************** //


// ********************* pie chart start here ***************** //
//  pie 1 -------- basic
const pie1 = {
  series: [44, 55, 13, 43, 22],
  chart: {
    type: 'pie',
  },
  labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
};


const pieSelector1 = document.querySelector("#pieChart1");
if (pieSelector1) {
  const pieChart1 = new ApexCharts(pieSelector1, pie1);
  pieChart1.render();
}


//  pie 2 -------- basic
const pie2 = {
  series: [44, 55, 41, 17, 15],
  chart: {
    type: 'donut',
  },
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
};


const pieSelector2 = document.querySelector("#pieChart2");
if (pieSelector2) {
  const pieChart2 = new ApexCharts(pieSelector2, pie2);
  pieChart2.render();
}


//  pie 3 -------- basic
const pie3 = {
  series: [25, 15, 44, 55, 41, 17],
  chart: {
    type: 'pie',
  },
  labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
  theme: {
    monochrome: {
      enabled: true
    }
  },
  plotOptions: {
    pie: {
      dataLabels: {
        offset: -5
      }
    }
  },
  dataLabels: {
    formatter(val, opts) {
      const name = opts.w.globals.labels[opts.seriesIndex]
      return [name, val.toFixed(1) + '%']
    }
  },
  legend: {
    show: false
  }
};


const pieSelector3 = document.querySelector("#pieChart3");
if (pieSelector3) {
  const pieChart3 = new ApexCharts(pieSelector3, pie3);
  pieChart3.render();
}



//  pie 4 -------- basic
const pie4 = {
  series: [44, 55, 41, 17, 15],
  chart: {
    type: 'donut',
  },
  plotOptions: {
    pie: {
      startAngle: -90,
      endAngle: 270
    }
  },
  dataLabels: {
    enabled: false
  },
  fill: {
    type: 'gradient',
  },
  legend: {
    formatter: function (val, opts) {
      return val + " - " + opts.w.globals.series[opts.seriesIndex]
    }
  },
  title: {
    text: 'Gradient Donut with custom Start-angle'
  },
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
};


const pieSelector4 = document.querySelector("#pieChart4");
if (pieSelector4) {
  const pieChart4 = new ApexCharts(pieSelector4, pie4);
  pieChart4.render();

}

//  pie 5 -------- basic

const pie5 = {
  series: [44, 55, 41, 17, 15],
  chart: {
    type: 'donut',
    dropShadow: {
      enabled: true,
      color: '#111',
      top: -1,
      left: 3,
      blur: 3,
      opacity: 0.2
    }
  },
  stroke: {
    width: 0,
  },
  plotOptions: {
    pie: {
      donut: {
        labels: {
          show: true,
          total: {
            showAlways: true,
            show: true
          }
        }
      }
    }
  },
  labels: ["Comedy", "Action", "SciFi", "Drama", "Horror"],
  dataLabels: {
    dropShadow: {
      blur: 3,
      opacity: 0.8
    }
  },
  fill: {
    type: 'pattern',
    opacity: 1,
    pattern: {
      enabled: true,
      style: ['verticalLines', 'squares', 'horizontalLines', 'circles', 'slantedLines'],
    },
  },
  states: {
    hover: {
      filter: 'none'
    }
  },
  theme: {
    palette: 'palette2'
  },
  title: {
    text: "Favourite Movie Type"
  },
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
};


const pieSelector5 = document.querySelector("#pieChart5");
if (pieSelector5) {
  const pieChart5 = new ApexCharts(pieSelector5, pie5);
  pieChart5.render();

}



//  pie 6 -------- basic
const pie6 = {
  series: [14, 23, 21, 17, 15, 10, 12, 17, 21],
  chart: {
    type: 'polarArea',
  },
  stroke: {
    colors: ['#fff']
  },
  fill: {
    opacity: 0.8
  },
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
};


const pieSelector6 = document.querySelector("#pieChart6");
if (pieSelector6) {
  const pieChart6 = new ApexCharts(pieSelector6, pie6);
  pieChart6.render();

}



//  pie 7 -------- basic
const pie7 = {
  series: [42, 47, 52, 58, 65],
  chart: {
    width: 380,
    type: 'polarArea'
  },
  labels: ['Rose A', 'Rose B', 'Rose C', 'Rose D', 'Rose E'],
  fill: {
    opacity: 1
  },
  stroke: {
    width: 1,
    colors: undefined
  },
  yaxis: {
    show: false
  },
  legend: {
    position: 'bottom'
  },
  plotOptions: {
    polarArea: {
      rings: {
        strokeWidth: 0
      },
      spokes: {
        strokeWidth: 0
      },
    }
  },
  theme: {
    monochrome: {
      enabled: true,
      shadeTo: 'light',
      shadeIntensity: 0.6
    }
  }
};



const pieSelector7 = document.querySelector("#pieChart7");
if (pieSelector7) {
  const pieChart7 = new ApexCharts(pieSelector7, pie7);
  pieChart7.render();

}

// ********************* pie chart end here ***************** //


// ********************* radar chart start here ***************** //
// radar chart 1
const radar1 = {
  series: [{
    name: 'Series 1',
    data: [80, 50, 30, 40, 100, 20],
  }],
  chart: {
    type: 'radar',
  },
  title: {
    text: 'Basic Radar Chart'
  },
  xaxis: {
    categories: ['January', 'February', 'March', 'April', 'May', 'June']
  }
};



const radarSelector1 = document.querySelector("#radarChart1");
if (radarSelector1) {
  const radarChart1 = new ApexCharts(radarSelector1, radar1);
  radarChart1.render();
}


// radar chart 2
const radar2 = {
  series: [{
    name: 'Series 1',
    data: [80, 50, 30, 40, 100, 20],
  }, {
    name: 'Series 2',
    data: [20, 30, 40, 80, 20, 80],
  }, {
    name: 'Series 3',
    data: [44, 76, 78, 13, 43, 10],
  }],
  chart: {
    type: 'radar',
    dropShadow: {
      enabled: true,
      blur: 1,
      left: 1,
      top: 1
    }
  },
  title: {
    text: 'Radar Chart - Multi Series'
  },
  stroke: {
    width: 2
  },
  fill: {
    opacity: 0.1
  },
  markers: {
    size: 0
  },
  xaxis: {
    categories: ['2011', '2012', '2013', '2014', '2015', '2016']
  }
};


const radarSelector2 = document.querySelector("#radarChart2");
if (radarSelector2) {
  const radarChart2 = new ApexCharts(radarSelector2, radar2);
  radarChart2.render();
}



// radar chart 3
const radar3 = {
  series: [{
    name: 'Series 1',
    data: [20, 100, 40, 30, 50, 80, 33],
  }],
  chart: {
    type: 'radar',
  },
  dataLabels: {
    enabled: true
  },
  plotOptions: {
    radar: {
      size: 140,
      polygons: {
        strokeColors: '#e9e9e9',
        fill: {
          colors: ['#f8f8f8', '#fff']
        }
      }
    }
  },
  title: {
    text: 'Radar with Polygon Fill'
  },
  colors: ['#FF4560'],
  markers: {
    size: 4,
    colors: ['#fff'],
    strokeColor: '#FF4560',
    strokeWidth: 2,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val
      }
    }
  },
  xaxis: {
    categories: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
  },
  yaxis: {
    tickAmount: 7,
    labels: {
      formatter: function (val, i) {
        if (i % 2 === 0) {
          return val
        } else {
          return ''
        }
      }
    }
  }
};



const radarSelector3 = document.querySelector("#radarChart3");
if (radarSelector3) {
  const radarChart3 = new ApexCharts(radarSelector3, radar3);
  radarChart3.render();
}



// ********************* radar chart end here ***************** //



// ********************* radial bar chart start here ***************** //
// radial bar chart 1
const radial1 = {
  series: [70],
  chart: {
    height: 350,
    type: 'radialBar',
  },
  plotOptions: {
    radialBar: {
      hollow: {
        size: '70%',
      }
    },
  },
  labels: ['Cricket'],
};



const radialSelector1 = document.querySelector("#radialChart1");
if (radialSelector1) {
  const radialChart1 = new ApexCharts(radialSelector1, radial1);
  radialChart1.render();
}

// radial bar chart 2
const radial2 = {
  series: [44, 55, 67, 83],
  chart: {
    height: 350,
    type: 'radialBar',
  },
  plotOptions: {
    radialBar: {
      dataLabels: {
        name: {
          fontSize: '22px',
        },
        value: {
          fontSize: '16px',
        },
        total: {
          show: true,
          label: 'Total',
          formatter: function (w) {
            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
            return 249
          }
        }
      }
    }
  },
  labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
};


const radialSelector2 = document.querySelector("#radialChart2");
if (radialSelector2) {
  const radialChart2 = new ApexCharts(radialSelector2, radial2);
  radialChart2.render();
}



// radial bar chart 3
const radial3 = {
  series: [76, 67, 61, 90],
  chart: {
    type: 'radialBar',
  },
  plotOptions: {
    radialBar: {
      offsetY: 0,
      startAngle: 0,
      endAngle: 270,
      hollow: {
        margin: 5,
        size: '30%',
        background: 'transparent',
        image: undefined,
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          show: false,
        }
      }
    }
  },
  colors: ['#1ab7ea', '#0084ff', '#39539E', '#0077B5'],
  labels: ['Vimeo', 'Messenger', 'Facebook', 'LinkedIn'],
  legend: {
    show: true,
    floating: true,
    fontSize: '16px',
    position: 'left',
    offsetX: 160,
    offsetY: 15,
    labels: {
      useSeriesColors: true,
    },
    markers: {
      size: 0
    },
    formatter: function (seriesName, opts) {
      return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
    },
    itemMargin: {
      vertical: 3
    }
  },
  responsive: [{
    breakpoint: 480,
    options: {
      legend: {
        show: false
      }
    }
  }]
};


const radialSelector3 = document.querySelector("#radialChart3");
if (radialSelector3) {
  const radialChart3 = new ApexCharts(radialSelector3, radial3);
  radialChart3.render();
}



// radial bar chart 4
const radial4 = {
  series: [75],
  chart: {
    height: 350,
    type: 'radialBar',
    toolbar: {
      show: true
    }
  },
  plotOptions: {
    radialBar: {
      startAngle: -135,
      endAngle: 225,
      hollow: {
        margin: 0,
        size: '70%',
        background: '#fff',
        image: undefined,
        imageOffsetX: 0,
        imageOffsetY: 0,
        position: 'front',
        dropShadow: {
          enabled: true,
          top: 3,
          left: 0,
          blur: 4,
          opacity: 0.24
        }
      },
      track: {
        background: '#fff',
        strokeWidth: '67%',
        margin: 0, // margin is in pixels
        dropShadow: {
          enabled: true,
          top: -3,
          left: 0,
          blur: 4,
          opacity: 0.35
        }
      },

      dataLabels: {
        show: true,
        name: {
          offsetY: -10,
          show: true,
          color: '#888',
          fontSize: '17px'
        },
        value: {
          formatter: function (val) {
            return parseInt(val);
          },
          color: '#111',
          fontSize: '36px',
          show: true,
        }
      }
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'dark',
      type: 'horizontal',
      shadeIntensity: 0.5,
      gradientToColors: ['#ABE5A1'],
      inverseColors: true,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 100]
    }
  },
  stroke: {
    lineCap: 'round'
  },
  labels: ['Percent'],
};


const radialSelector4 = document.querySelector("#radialChart4");
if (radialSelector4) {
  const radialChart4 = new ApexCharts(radialSelector4, radial4);
  radialChart4.render();
}



// radial bar chart 5
const radial5 = {
  series: [67],
  chart: {
    height: 350,
    type: 'radialBar',
    offsetY: -10
  },
  plotOptions: {
    radialBar: {
      startAngle: -135,
      endAngle: 135,
      dataLabels: {
        name: {
          fontSize: '16px',
          color: undefined,
          offsetY: 120
        },
        value: {
          offsetY: 76,
          fontSize: '22px',
          color: undefined,
          formatter: function (val) {
            return val + "%";
          }
        }
      }
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'dark',
      shadeIntensity: 0.15,
      inverseColors: false,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 50, 65, 91]
    },
  },
  stroke: {
    dashArray: 4
  },
  labels: ['Median Ratio'],
};


const radialSelector5 = document.querySelector("#radialChart5");
if (radialSelector5) {
  const radialChart5 = new ApexCharts(radialSelector5, radial5);
  radialChart5.render();
}


// radial bar chart 6
const radial6 = {
  series: [76],
  chart: {
    height: 350,
    type: 'radialBar',
    offsetY: -20,
    sparkline: {
      enabled: true
    }
  },
  plotOptions: {
    radialBar: {
      startAngle: -90,
      endAngle: 90,
      track: {
        background: "#e7e7e7",
        strokeWidth: '97%',
        margin: 5, // margin is in pixels
        dropShadow: {
          enabled: true,
          top: 2,
          left: 0,
          color: '#999',
          opacity: 1,
          blur: 2
        }
      },
      dataLabels: {
        name: {
          show: false
        },
        value: {
          offsetY: -2,
          fontSize: '22px'
        }
      }
    }
  },
  grid: {
    padding: {
      top: -10
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      shade: 'light',
      shadeIntensity: 0.4,
      inverseColors: false,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 50, 53, 91]
    },
  },
  labels: ['Average Results'],
};


const radialSelector6 = document.querySelector("#radialChart6");
if (radialSelector6) {
  const radialChart6 = new ApexCharts(radialSelector6, radial6);
  radialChart6.render();
}


// ********************* radial bar chart end here ***************** //
