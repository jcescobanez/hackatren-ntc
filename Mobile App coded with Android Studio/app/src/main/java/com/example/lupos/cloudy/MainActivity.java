package com.example.lupos.cloudy;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.InstanceIdResult;
import com.google.firebase.messaging.FirebaseMessaging;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {

    //public static final String INSERT_TOKEN_SERVER_URL = "http://192.168.1.10:8080/register.php";


        @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


    }

    public void stationqueue(View v){
        Intent i = new Intent(MainActivity.this, Stationqueue.class);
        startActivity(i);
    }

    public void beep(View v){
        Intent i = new Intent(MainActivity.this, Beep.class);
        startActivity(i);
    }
    public void back(View v){
        Intent i = new Intent(MainActivity.this, Login.class);
        startActivity(i);
    }


}
