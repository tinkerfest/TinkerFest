var HelloComponent = React.createClass({
	 render: function() {
	     return (
	         <Repeat numTimes={10}>
      				{(index) => <div key={index}>This is item {index} in the list</div>}
    		</Repeat>
	     )
	 }
 })


var Repeat = React.createClass({
  render:function(){
	  let items = [];
	  for (let i = 0; i < this.props.numTimes; i++) {
	    items.push(this.props.children(i));
	  }
  	return <div>{items}</div>;
  }
});


 ReactDOM.render(<HelloComponent />, document.querySelector('#app'))