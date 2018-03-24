import React from 'react';
import PropTypes from 'prop-types';
import Collapsible from './Collapsible';

export class CollapsibleCon extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			value: '',
			response: '',
			lastAdd: '',
		};
		this.addStock = this.addStock.bind(this);
		this.removeStock = this.removeStock.bind(this);
		this.handleChange = this.handleChange.bind(this);
	}
	handleChange(e) {
		this.setState({ value: e.target.value });
	}
	addStock(e) {
		e.preventDefault();
		this.props.newStock(this.state.value, this.state.socket);
		this.setState({ value: '' });
	}
	removeStock(ind, stockCode) {
		this.props.deleteStock(ind, stockCode);
	}
	render() {
		return (
			<div>
				<Collapsible
					stocks={this.props.stocks}
					addStock={this.addStock}
					removeStock={this.removeStock}
					onChange={this.handleChange}
					value={this.state.value}
				/>
			</div>
		);
	}
}

export default CollapsibleCon;
