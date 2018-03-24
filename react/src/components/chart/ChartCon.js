import React from 'react';
import PropTypes from 'prop-types';
import Chart from './Chart';
import { toastOptions, calculateTicks } from '../../helper';


class ChartCon extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			value: '',
		};
	}

	renderChart(props) {

		if (props.stock_data[0] === undefined) {
			return <div>Currently no data is available</div>;
		}
    else {
			const arrayColumn = (arr, n) => arr.map(x => x[n]);
			let data = [];
			let tickValues = [];

  	  props.stock_data.map((stock, ind) => {
    		const date_col = arrayColumn(stock.dataset_data.data, 0);
    		const index_col = arrayColumn(stock.dataset_data.data, 1);
    		const dates = date_col.map(date => new Date(date).getTime());
    		tickValues.push([]);
    		tickValues[ind] = calculateTicks(dates, ind);

    		let len = stock.dataset_data.data.length;
    		data.push([]);
    		for (var i = 0; i < len; i++) {
    			data[0].push({
    				x: dates[i],
    				y: index_col[i]
    			});
    		}
  	  });

			return (
				<div>
        <p>{this.state.value}</p>
					<Chart data={data} tickValues={tickValues} stock_data={props.stock_data} />
				</div>
			);
		}
	}

	render() {
		return (
			<div>
				{this.renderChart(this.props)}
			</div>
		);
	}
}

export default ChartCon;

ChartCon.propTypes = {
	stock_data: PropTypes.arrayOf(
		PropTypes.shape({
			dataset: PropTypes.shape({
				database_code: PropTypes.string.isRequired,
				name: PropTypes.string.isRequired
			})
		})
	).isRequired
};
