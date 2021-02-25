import './App.css';
import { BrowserRouter as Router, Route } from "react-router-dom";
import { MainPage } from './components/MainPage';

const App = () => {
    let content = (
        <Router>
            <div className="App">
              <Route exact path="/" component={MainPage}></Route>
            </div>
        </Router>
  );
  return content;
}

export default App;
