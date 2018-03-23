import React, { Component } from 'react';
import Header from './components/Header';
import Footer from './components/Footer';
import ChartCon from './components/chart/ChartCon.js';
import CollapsibleCon from './components/sidebar/CollapsibleCon.js'


class App extends Component {
	constructor() {
    super();
    this.state = {
      response: false,
      endpoint: "http://127.0.0.1:9000",
      stocks: [],
      labels: [],
    };
	}

  getData() {
    // fetch('https://www.quandl.com/api/v3/datasets/WIKI/GOOG/data.json', {
    //   method: 'GET',
    //   headers: {
    //     Accept: 'application/json',
    //   },
    // })
    // .then((response) => response.json())
    // .then((data) => {
    //   let counter = [];
    //   counter.push(data);
    //   this.setState({stocks: counter});
    // })
    // .catch((error) => {
    //   console.error(error);
    // });

    var data = require('../data/data.json');
    let counter = [];
    counter.push(data);
    this.setState({stocks: counter});

    var stkdat = require('../data/stocks.json')
    let lcounter = [];
    lcounter.push(stkdat);
    this.setState({labels: lcounter});
  }

	componentDidMount() {
    this.getData();
  }

	render() {
		return (
			<div
				style={{
					display: 'flex',
					minHeight: '100vh',
					flexDirection: 'column'
				}}
			>
				<Header />
				<main className="grey">
					<div className="row">
						<div className="col s12 sm9">
							<ChartCon stock_data={this.state.stocks} />
						</div>
            <div className="col s12 m3">
              <CollapsibleCon stocks={this.state.labels} />
            </div>
					</div>
				</main>
        <Footer />
			</div>
		);
	}
}

export default App;
