#include <bits/stdc++.h>
using namespace std;
int main(){
         freopen("out.txt","w",stdout);
   int t,n,p;
   cin>>t;
   while(t--){
      cin>>n>>p;
      int tc=2; 
      while(tc--){
         //randomly choose any p values <= 100
         vector<int> val(p);
         for(int i=0;i<p;i++)val.push_back(rand()%100);
         
         for(int i=0;i<n;i++){
            for(int j=0;j<n;j++){
               int r = rand()%100;
               
               if(find(val.begin(),val.end(),r) != val.end()){
                  cout<<"1";
               } else {
                  cout<<"0";
               }
               if(j!=n-1)cout<<" ";
            }
            cout<<"\n";
         }
         cout<<"TESTCASE END------------------------------\n";
      }
      cout<<"TESTFILE END------------------------------------------------------\n";
   }
   
   return 0;
}