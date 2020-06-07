class SuggestToursOnSearch extends React.Component {
   constructor(props) {
      super(props);
      
      this.state = {
         value: '',
         tours: [],
         dests: []
      }
      this.updateState = this.updateState.bind(this);
      this.clickResult = this.clickResult.bind(this);
   };
   updateState(e) {
      var $this = this;
      var val = e.target.value;
      $('.res-title').show();
      
      if(val != ""){
          $('.resultsData').show();
          $.request('onSearch', { 
            data:{
                search:$this.state.value,
                limit:5
            }, 
            success:function(response) { 
              console.log(response);
                $this.setState({tours: response.tours});
                $this.setState({dests: response.destinations});
                if ( $this.state.tours && $this.state.tours.length > 0 ) {
                    $this.items = $this.state.tours.map((item, key) =>
                        <li onClick={$this.clickResult}>{item.title}</li>
                    );
                }
                else{
                    $this.items = "";
                }

                if ( $this.state.tours && $this.state.dests.length > 0 ) {
                    $this.dests = $this.state.dests.map((item, key) =>
                        <li onClick={$this.clickResult}>{item.name}</li>
                    );
                }
                else{
                    $this.dests = "";
                }
            }  
          });

      }
      else{
        $this.items = "";
        $('.resultsData').hide();
        //console.log('nije prosao 2');
      }
      this.setState({value: e.target.value});
   };
   clickResult(e){
    this.setState({ value: e.target.innerText });

    this.items = "";
    $('.resultsData').hide();
    initSearch(e,e.target.innerText);
   };
   render() {
      return (
         <div>
         <input type="text" name="search" className="search-text" autocomplete="off" placeholder="What are you looking for?" 
         onChange = {this.updateState} value={this.state.value} />
            <ul className="resultsData">
            { this.dests ?
              <li className="result-places res-title"><span><i className="icon-destinations"></i>Places</span>
                <ul>
                  {this.dests}
                </ul>
              </li> : null
            }
             { this.items ?
              <li className="result-tours res-title"><span><i className="icon-tours"></i>Tours</span>
                <ul>
                  {this.items}
                </ul>
              </li> : null
            }
            </ul>
         </div>
      );
   };
}

ReactDOM.render(<SuggestToursOnSearch />, document.getElementById('suggestionContainer'));