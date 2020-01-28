import React, {useEffect, useState} from 'react';
import { StyleSheet, Image } from 'react-native';
import MapView, {Marker} from 'react-native-maps';
import {requestPermissionsAsync, getCurrentPositionAsync} from 'expo-location';

function Main() {

  const [currentRegion, SetCurrentRegion] = useState(null);

  useEffect(() => {
    async function loadAsyncPosition(){
      const { granted } = await requestPermissionsAsync();

      if(granted){
        const {coords} = await getCurrentPositionAsync({
          enableHighAccuracy: true,
        });

        const {latitude, longitude} = coords

        SetCurrentRegion({
          latitude, 
          longitude,
          latitudeDelta: 0.04, 
          longitudeDelta: 0.04, 
        }) 
      }
    }

    loadAsyncPosition();
  }, [])

  if(!currentRegion){
    return null;
  }

  return (
    <MapView initialRegion={currentRegion} style={styles.map}>
      <Marker
      coordinate={currentRegion}
      title={"Mexk1"}
      description={"teste"}
      >
        <Image 
          style={styles.marker}
          source={{uri:'https://avatars3.githubusercontent.com/u/45496687?s=460&amp;v=4'}}
        />
      </Marker>
    </MapView>
  );
}

const styles = StyleSheet.create({
    map: {
      flex: 1
    },
    marker: {
      borderRadius: 25,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      width: 50,
      height: 50,
      borderColor: '#FFF'
    }
  }
)


export default Main;

