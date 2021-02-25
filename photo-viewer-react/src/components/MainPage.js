import React, { useEffect, useState } from 'react';
import apiService from "../services/ApiService";

export const MainPage = () => {

    const [photos,setPhotos] = useState([]);

    useEffect(() => {
        async function getPhotos() {
            const response = await apiService.getPhotos();
            console.log("response", response);
            setPhotos(response.data);
        }
        getPhotos();
    }, []);

    return (
        <div>
            <h1>Welcome in PhotoLand!</h1>
            <p>Main paaaaaaaaaageg</p>
            <table>
                <tr>
                    <th>Caption</th>
                    <th>Descritption</th>
                    <th>View_count</th>
                </tr>
                { photos.map((row) => (
                    <tr>
                        <td>{ row.caption }</td>
                        <td>{ row.description }</td>
                        <td>{ row.view_count }</td>
                        <td>Edit</td>
                        <td>Delete</td>
                    </tr>
                ))}

            </table>
        </div>
    )
}
