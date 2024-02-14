# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {ACCESS_TOKEN}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

You can generate Access Token using Client ID from profile section and Project ID from project list.
            Concatenate them together with colon(:) and use base64 algorithm to encode this string.<br/><br/>
            <b>Pass this encodedString to Request Header for Below API Call.</b><br/><br/>
            Check the example 
            <aside>
                $string = {CLIENT_ID}:{PROJECT_ID};<br/>
                $encodedString = base64_encode($string);
            </aside>
            
        
