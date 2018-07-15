package com.example.lupos.cloudy;

import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Intent;
import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.InstanceIdResult;
import com.google.firebase.messaging.FirebaseMessaging;

import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Login extends AppCompatActivity {

    String token, username, password;

    EditText et_username, et_password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        et_username = (EditText)findViewById(R.id.username);
        et_password = (EditText)findViewById(R.id.password);

    }

    public void login(View view){
        username = et_username.getText().toString();
        password = et_password.getText().toString();
        FirebaseMessaging.getInstance().subscribeToTopic("test");
        FirebaseInstanceId.getInstance().getInstanceId().addOnSuccessListener( Login.this,  new OnSuccessListener<InstanceIdResult>() {
            @Override
            public void onSuccess(InstanceIdResult instanceIdResult) {
                token = instanceIdResult.getToken();
            }
        });

        execute();

    }

    private Dialog loadingDialog;
    RequestQueue queue;

    public void execute(){
        queue = Volley.newRequestQueue(this);
        loadingDialog = ProgressDialog.show(Login.this, "", "Loading...");
        String url = "http://bshscare.com/Zipp/app/api/android_api/app_login";

        StringRequest req = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                loadingDialog.dismiss();
                Toast.makeText(Login.this, response, Toast.LENGTH_SHORT).show();
                try {


                    String status = new JSONObject(response).getString("status");

                    if (status.equals("FAILED")) {

                        Toast.makeText(Login.this, "Invalid Username or Password.", Toast.LENGTH_LONG).show();

                    } else {

                        Toast.makeText(Login.this, "User logged in successfully.", Toast.LENGTH_LONG).show();
                        PreferenceManager
                                .getDefaultSharedPreferences(Login.this)
                                .edit()
                                .putString("jsondata", response)
                                .commit();

                        Intent i = new Intent(Login.this, MainActivity.class);
                        startActivity(i);

                    }

                } catch (JSONException e) {

                    e.printStackTrace();

                }


            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                loadingDialog.dismiss();

            }
        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("username", username);
                params.put("password", password);
                params.put("token", token);

                return params;
            }
        };

        req.setRetryPolicy(new DefaultRetryPolicy(
                0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));


        queue.add(req);
    }


}
