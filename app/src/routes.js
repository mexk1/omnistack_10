import {createAppContainer} from 'react-navigation';
import {createStackNavigator} from 'react-navigation-stack';

import Main from './pages/Main';
import Profile from './pages/Profile';

const Routes = createAppContainer(
   createStackNavigator({
     Main: {
       screen: Main,
       navigationOptions: {
         title: 'DevRadar'
       }
     },
     Profile
   }, {
     defaultNavigationOptions: {
       headerStyle:{
         backgroundColor: '#d5b5e7'
       },
       headerTitleAlign: 'center'
     }
   })
)

export default Routes;